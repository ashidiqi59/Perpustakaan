<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Loan extends Model
{
    use HasFactory;

    // Status Constants
    const STATUS_MENUNGGU_KONFIRMASI  = 'menunggu_konfirmasi';   // Setelah user ajukan, belum di-scan petugas
    const STATUS_PEMINJAMAN           = 'peminjaman';             // Sudah di-scan petugas, buku aktif dipinjam
    const STATUS_MENUNGGU_PENGEMBALIAN = 'menunggu_pengembalian'; // User minta kembali, belum di-scan
    const STATUS_DIKEMBALIKAN         = 'dikembalikan';           // Sudah dikembalikan (scan kembali oleh petugas)
    const STATUS_TERLAMBAT            = 'terlambat';              // Melewati due_date, belum dikembalikan
    const STATUS_EXPIRED              = 'expired';                // Barcode pinjam hangus, tidak jadi pinjam

    // Barcode expiry duration (hours)
    const BARCODE_EXPIRY_HOURS = 2;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
        'loan_barcode',
        'loan_barcode_expires_at',
        'loan_barcode_scanned_at',
        'return_barcode',
        'return_barcode_expires_at',
        'return_barcode_scanned_at',
    ];

    protected $casts = [
        'loan_date'                 => 'date',
        'due_date'                  => 'date',
        'return_date'               => 'date',
        'loan_barcode_expires_at'   => 'datetime',
        'loan_barcode_scanned_at'   => 'datetime',
        'return_barcode_expires_at' => 'datetime',
        'return_barcode_scanned_at' => 'datetime',
    ];

    /**
     * Get the user that borrowed the book
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // =========================================================================
    // BARCODE GENERATION
    // =========================================================================

    /**
     * Generate a unique loan barcode token and set expiry.
     * Called when user submits borrow request.
     */
    public function generateLoanBarcode(): string
    {
        $token = $this->generateUniqueToken('PINJAM');

        $this->update([
            'loan_barcode'            => $token,
            'loan_barcode_expires_at' => now()->addHours(self::BARCODE_EXPIRY_HOURS),
            'loan_barcode_scanned_at' => null,
        ]);

        return $token;
    }

    /**
     * Generate a unique return barcode token and set expiry.
     * Called when user requests book return.
     */
    public function generateReturnBarcode(): string
    {
        $token = $this->generateUniqueToken('KEMBALI');

        $this->update([
            'return_barcode'            => $token,
            'return_barcode_expires_at' => now()->addHours(self::BARCODE_EXPIRY_HOURS),
            'return_barcode_scanned_at' => null,
        ]);

        return $token;
    }

    /**
     * Generate a unique token with prefix to prevent collision between loan/return barcodes.
     * Format: {PREFIX}-{loanId}-{timestamp}-{random}
     */
    private function generateUniqueToken(string $prefix): string
    {
        return strtoupper($prefix) . '-' . $this->id . '-' . now()->timestamp . '-' . Str::random(16);
    }

    // =========================================================================
    // BARCODE VALIDATION
    // =========================================================================

    /**
     * Check if loan barcode is still valid (not expired, not yet scanned)
     */
    public function isLoanBarcodeValid(): bool
    {
        return $this->loan_barcode !== null
            && $this->loan_barcode_scanned_at === null
            && $this->loan_barcode_expires_at !== null
            && now()->isBefore($this->loan_barcode_expires_at);
    }

    /**
     * Check if return barcode is still valid (not expired, not yet scanned)
     */
    public function isReturnBarcodeValid(): bool
    {
        return $this->return_barcode !== null
            && $this->return_barcode_scanned_at === null
            && $this->return_barcode_expires_at !== null
            && now()->isBefore($this->return_barcode_expires_at);
    }

    /**
     * Get remaining seconds for loan barcode
     */
    public function getLoanBarcodeRemainingSeconds(): int
    {
        if (!$this->loan_barcode_expires_at) return 0;
        return max(0, now()->diffInSeconds($this->loan_barcode_expires_at, false));
    }

    /**
     * Get remaining seconds for return barcode
     */
    public function getReturnBarcodeRemainingSeconds(): int
    {
        if (!$this->return_barcode_expires_at) return 0;
        return max(0, now()->diffInSeconds($this->return_barcode_expires_at, false));
    }

    // =========================================================================
    // STATUS LOGIC
    // =========================================================================

    /**
     * Check if loan is overdue
     */
    public function isOverdue(): bool
    {
        if ($this->return_date !== null) {
            return false;
        }
        return now()->isAfter($this->due_date);
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdue(): int
    {
        if ($this->return_date !== null) {
            return 0;
        }
        if (!$this->isOverdue()) {
            return 0;
        }
        return now()->diffInDays($this->due_date);
    }

    /**
     * Get actual status based on current state.
     *
     * Logic:
     * - return_date is set               = Dikembalikan
     * - status expired                   = Expired
     * - status menunggu_konfirmasi       = Menunggu Konfirmasi (barcode pinjam belum di-scan)
     * - status menunggu_pengembalian     = Menunggu Pengembalian (barcode kembali belum di-scan)
     * - return_date null & today > due   = Terlambat
     * - return_date null & today <= due  = Peminjaman
     */
    public function getActualStatus(): string
    {
        if ($this->return_date !== null) {
            return self::STATUS_DIKEMBALIKAN;
        }

        if ($this->status === self::STATUS_EXPIRED) {
            return self::STATUS_EXPIRED;
        }

        if ($this->status === self::STATUS_MENUNGGU_KONFIRMASI) {
            if ($this->loan_barcode_expires_at && now()->isAfter($this->loan_barcode_expires_at)) {
                return self::STATUS_EXPIRED;
            }
            return self::STATUS_MENUNGGU_KONFIRMASI;
        }

        if ($this->status === self::STATUS_MENUNGGU_PENGEMBALIAN) {
            return self::STATUS_MENUNGGU_PENGEMBALIAN;
        }

        // Active loan: check overdue
        if ($this->due_date->isBefore(today())) {
            return self::STATUS_TERLAMBAT;
        }

        return self::STATUS_PEMINJAMAN;
    }

    /**
     * Get days late (for display purposes)
     */
    public function getDaysLate(): int
    {
        if ($this->return_date !== null && $this->return_date->isAfter($this->due_date)) {
            return $this->return_date->diffInDays($this->due_date);
        }

        if ($this->due_date->isBefore(today())) {
            return today()->diffInDays($this->due_date);
        }

        return 0;
    }
}
