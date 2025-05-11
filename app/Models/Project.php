<?php

// app/Models/Project.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'status',
        'needs_volunteers',
        'needs_donations'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'needs_volunteers' => 'boolean',
        'needs_donations' => 'boolean'
    ];

    public function gallery()
    {
        return $this->morphOne(MediaGallery::class, 'related');
    }
}