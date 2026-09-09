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

    /**
     * Generate pure SVG string for the QR code
     */
    public function getQrCodeSvg(int $size = 200): string
    {
        try {
            return (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size($size)
                ->errorCorrection('H')
                ->generate($this->barcode_code);
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * Generate base64 Data URI for <img> tag
     */
    public function getQrCodeDataUri(int $size = 200): string
    {
        $svg = $this->getQrCodeSvg($size);
        if (!empty($svg)) {
            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        }
        return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&data=' . urlencode($this->barcode_code) . '&format=png&margin=2';
    }
}
