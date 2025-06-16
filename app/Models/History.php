<?php
// app/Models/History.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'founder_name',
        'founder_description'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Boot function pour les événements du modèle
     */
    protected static function boot()
    {
        parent::boot();
        
        // Générer un slug lors de la création
        static::creating(function ($history) {
            if (!$history->slug) {
                $history->slug = Str::slug($history->title);
            }
        });
        
        // Générer un slug lors de la mise à jour si le titre change
        static::updating(function ($history) {
            if ($history->isDirty('title')) {
                $history->slug = Str::slug($history->title);
            }
        });
    }
    
    /**
     * Retourne le chemin complet de l'image
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        return null;
    }
    
    /**
     * Scope pour récupérer par slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}