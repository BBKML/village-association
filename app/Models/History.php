<?php

// app/Models/History.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'founder_name',
        'founder_description'
    ];
}