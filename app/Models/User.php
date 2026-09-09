<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN     = 'admin';
    const ROLE_PETUGAS   = 'petugas';
    const ROLE_PENGUNJUNG = 'pengunjung';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'npm',
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'phone',
        'prodi',
        'address',
        'remember_token',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is petugas (staff/operator)
     */
    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    /**
     * Check if user is pengunjung
     */
    public function isPengunjung(): bool
    {
        return $this->role === self::ROLE_PENGUNJUNG;
    }

    /**
     * Check if user can access petugas scanner (admin or petugas)
     */
    public function canScan(): bool
    {
        return $this->isPetugas() || $this->isAdmin();
    }

    /**
     * Check if user registered via Google
     */
    public function isGoogleUser(): bool
    {
        return !empty($this->google_id);
    }

    /**
     * Check if user's profile is complete (e.g., NPM is filled)
     */
    public function isProfileComplete(): bool
    {
        return !empty($this->npm);
    }

    /**
     * Get user avatar URL or fallback to initial avatar
     */
    public function getAvatarUrl(): string
    {
        if (!empty($this->avatar)) {
            return $this->avatar;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0F2854&color=ffffff&bold=true';
    }

    /**
     * Get the loans for the user
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get the member barcode (digital library card) for the user
     */
    public function memberBarcode()
    {
        return $this->hasOne(MemberBarcode::class);
    }

    /**
     * Get the attendance logs for the user
     */
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
