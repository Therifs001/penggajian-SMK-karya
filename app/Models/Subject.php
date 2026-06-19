<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = ['name', 'jam'];

    protected $casts = [
        'jam' => 'decimal:2',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'subject_user')->withTimestamps();
    }
}
