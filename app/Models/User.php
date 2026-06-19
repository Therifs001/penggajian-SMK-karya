<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Absensi;
use App\Models\Gaji;
use App\Models\KomponenGaji;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nip', 'matapelajaran', 'status', 'role', 'email', 'password', 'no_hp', 'alamat'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function absensi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function gaji(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Gaji::class);
    }

    public function komponenGaji(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(KomponenGaji::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function subjects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Subject::class, 'subject_user')->withTimestamps();
    }
}
