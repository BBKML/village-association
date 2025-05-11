<?php

// app/Models/Activity.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'date',
        'location'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function gallery()
    {
        return $this->morphOne(MediaGallery::class, 'related');
    }
}
