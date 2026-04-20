<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'user_id',
    'tanggal',
    'jam_masuk',
    'jam_keluar',
    'status',
    'alasan',
    'latitude',
    'longitude',
    'approved',
])]
class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'approved' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
