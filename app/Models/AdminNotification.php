<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $table = 'admin_notifications';

    protected $fillable = [
        'type',
        'data',
        'read',
    ];

    protected $casts = [
        'data' => 'array',
        'read' => 'boolean',
    ];
}
