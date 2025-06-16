<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'bio',
        'email',
        'phone',
        'joined_date',
        'image',
        'is_board_member'
    ];

    protected $casts = [
        'joined_date' => 'date',
        'is_board_member' => 'boolean'
    ];

    // Relationship with Association
    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    // Scope for board members
    public function scopeBoardMembers($query)
    {
        return $query->where('is_board_member', true);
    }
    
}