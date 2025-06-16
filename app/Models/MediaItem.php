<?php
// app/Models/MediaItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'file_path',
        'file_type',
        'caption',
        'alt_text',
        'order'
    ];

    /**
     * Relation avec la galerie parente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo(MediaGallery::class);
    }

    /**
     * Obtenir l'URL publique du fichier
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Vérifie si le média est une image
     *
     * @return bool
     */
    public function getIsImageAttribute()
    {
        return $this->file_type === 'image';
    }

    /**
     * Vérifie si le média est une vidéo
     *
     * @return bool
     */
    public function getIsVideoAttribute()
    {
        return $this->file_type === 'video';
    }

    /**
     * Actions au moment du cycle de vie du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Assigne un ordre par défaut lors de la création
        static::creating(function ($model) {
            if (is_null($model->order)) {
                $lastOrder = self::where('gallery_id', $model->gallery_id)->max('order') ?? 0;
                $model->order = $lastOrder + 1;
            }
        });

        // Supprime le fichier physique lors de la suppression du modèle
        static::deleting(function ($model) {
            if (Storage::disk('public')->exists($model->file_path)) {
                Storage::disk('public')->delete($model->file_path);
            }
        });
    }


}
