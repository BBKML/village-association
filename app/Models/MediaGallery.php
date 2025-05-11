<?php

// app/Models/MediaGallery.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'related_id',
        'related_type'
    ];

    public function related()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(MediaItem::class);
    }
}

