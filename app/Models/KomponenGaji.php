<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'user_id',
    'honor_per_jam',
    'transport',
    'bpjs',
    'potongan_lain',
    'periode',
])]
class KomponenGaji extends Model
{
    use HasFactory;

    protected $table = 'komponen_gaji';

    protected function casts(): array
    {
        return [
            'honor_per_jam' => 'decimal:2',
            'transport' => 'decimal:2',
            'bpjs' => 'decimal:2',
            'potongan_lain' => 'decimal:2',
        ];
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
