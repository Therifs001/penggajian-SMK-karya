<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'jam_mulai',
    'jam_selesai',
    'batas_absen',
    'latitude',
    'longitude',
    'radius_meter',
    'active',
])]
class AbsensiSetting extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'jam_mulai' => 'time',
            'jam_selesai' => 'time',
            'batas_absen' => 'time',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'radius_meter' => 'integer',
            'active' => 'boolean',
        ];
    }
}
