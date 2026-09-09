<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MemberBarcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barcode_code',
    ];

    /**
     * Get the user that owns this barcode
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique member barcode code for a given user ID.
     * Format: MEMBER-{userId}-{RANDOM8}
     */
    public static function generateCode(int $userId): string
    {
        do {
            $code = 'MEMBER-' . $userId . '-' . strtoupper(Str::random(8));
        } while (self::where('barcode_code', $code)->exists());

        return $code;
    }

    /**
     * Get or create a member barcode for a given user.
     */
    public static function getOrCreateForUser(User $user): self
    {
        return self::firstOrCreate(
            ['user_id' => $user->id],
            ['barcode_code' => self::generateCode($user->id)]
        );
    }
}
