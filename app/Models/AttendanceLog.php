<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'scan_date',
        'scanned_at',
        'notes',
    ];

    protected $casts = [
        'scan_date'  => 'date',
        'scanned_at' => 'datetime',
    ];

    /**
     * Get the user that checked in
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: only today's attendance
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scan_date', today());
    }

    /**
     * Scope: only this week's attendance
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('scan_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Check if a user has already checked in today
     */
    public static function hasCheckedInToday(int $userId): bool
    {
        return self::where('user_id', $userId)
            ->whereDate('scan_date', today())
            ->exists();
    }
}
