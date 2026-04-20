<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'user_id',
    'periode',
    'jam_mengajar',
    'honor_per_jam',
    'total_honor',
    'total_tunjangan',
    'total_potongan',
    'total_gaji',
    'kehadiran',
    'detail',
])]
class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected function casts(): array
    {
        return [
            'jam_mengajar' => 'decimal:2',
            'honor_per_jam' => 'decimal:2',
            'total_honor' => 'decimal:2',
            'total_tunjangan' => 'decimal:2',
            'total_potongan' => 'decimal:2',
            'total_gaji' => 'decimal:2',
            'detail' => 'array',
        ];
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
