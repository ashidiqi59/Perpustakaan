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
}
