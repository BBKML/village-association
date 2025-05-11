<?php

// app/Models/News.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'image',
        'is_published'
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean'
    ];
}
