<?php

// app/Models/ContactMessage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];
    public function scopeUnread($query)
    {
        return $query->where('is_read', false); // ou '0' selon ta base
    }
    // App\Models\ContactMessage.php
   public static function unread()
    {
        return static::where('is_read', false);
    }


}
