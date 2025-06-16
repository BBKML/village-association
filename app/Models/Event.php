<?php

// app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'image'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function gallery()
    {
        return $this->morphOne(MediaGallery::class, 'galleriable');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())
                    ->orderBy('start_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('end_date', '<', now())
                    ->orderBy('start_date', 'desc');
    }

    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('start_date', 'asc');
    }
    public function scopeWithGallery($query)
        {
            return $query->with('gallery.items');
        }
}