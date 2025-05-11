<?php
// app/Models/MediaItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'file_path',
        'file_type',
        'caption'
    ];

    public function gallery()
    {
        return $this->belongsTo(MediaGallery::class);
    }
}