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

    /**
     * Les types de galerie disponibles avec leurs libellés
     */
    public static $types = [
        'activity' => 'Activité',
        'project' => 'Projet',
        'event' => 'Événement',
        'other' => 'Autre'
    ];

    /**
     * Obtenir le libellé du type de galerie
     */
    public function getTypeLabelAttribute()
    {
        return self::$types[$this->type] ?? $this->type;
    }

    /**
     * Relation polymorphique avec d'autres modèles
     */
    public function related()
    {
        return $this->morphTo();
    }

    /**
     * Relation avec les éléments médias de la galerie
     */
    public function items()
    {
        return $this->hasMany(MediaItem::class, 'gallery_id')->orderBy('order', 'asc');
    }

    /**
     * Retourne le premier élément média (couverture)
     */
    public function getCoverAttribute()
    {
        return $this->items()->orderBy('order', 'asc')->first();
    }
}