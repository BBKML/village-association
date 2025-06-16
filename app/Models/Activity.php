<?php

// app/Models/Activity.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Activity extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'date',
        'location',
        'category',
        'time',
        'available_spots',
        'is_featured'
    ];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean'
    ];

    // Relation avec MediaGallery
    public function gallery()
    {
        return $this->morphOne(MediaGallery::class, 'related');
    }

    // Configuration du slug
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate(); // Évite de régénérer le slug à chaque mise à jour
    }

    // Route key name pour utiliser le slug dans les routes
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scopes utiles
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->startOfDay());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now()->startOfDay());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}