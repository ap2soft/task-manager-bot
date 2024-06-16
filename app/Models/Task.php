<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'complete'];

    protected $casts = [
        'complete' => 'boolean',
    ];

    protected $attributes = [
        'complete' => false,
    ];
}
