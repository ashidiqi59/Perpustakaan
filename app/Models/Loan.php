<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    const STATUS_PEMINJAMAN = 'peminjaman';
    const STATUS_DIKEMBALIKAN = 'dikembalikan';
    const STATUS_TERLAMBAT = 'terlambat';

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
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
     * Get actual status based on comparison between return_date and due_date
     * This is the displayed status that considers if book was returned late
     * 
     * Logic:
     * - return_date is set = Dikembalikan (book is returned, regardless of being late)
     * - return_date null & today > due_date = Terlambat (lewat dari due date, belum dikembalikan)
     * - return_date null & today <= due_date = Peminjaman (belum jatuh tempo)
     */
    public function getActualStatus(): string
    {
        // If return_date is set, book is returned (regardless of being late or not)
        if ($this->return_date !== null) {
            return self::STATUS_DIKEMBALIKAN;
        }

        // If not returned yet, check if overdue based on current date
        // Terlambat jika today SLEWIH due_date (bukan >=)
        if ($this->due_date->isBefore(today())) {
            return self::STATUS_TERLAMBAT;
        }

        return self::STATUS_PEMINJAMAN;
    }

    /**
     * Get days late (for display purposes)
     * Returns positive number if late, 0 if on time
     */
    public function getDaysLate(): int
    {
        // If returned late (return_date > due_date)
        if ($this->return_date !== null && $this->return_date->isAfter($this->due_date)) {
            return $this->return_date->diffInDays($this->due_date);
        }

        // If not returned and due date has passed (today > due_date)
        if ($this->due_date->isBefore(today())) {
            return today()->diffInDays($this->due_date);
        }

        return 0;
    }
}
