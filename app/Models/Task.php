<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'text', 'date', 'notify_at'];

    protected $casts = [
        'date' => 'datetime',
        'notify_at' => 'datetime',
    ];
}
