<?php

// app/Models/Project.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'status',
        'needs_volunteers',
        'needs_donations'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'needs_volunteers' => 'boolean',
        'needs_donations' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->status)) {
                $project->status = 'planned';
            }
        });
    }

    public function gallery()
    {
        return $this->morphOne(MediaGallery::class, 'related');
    }

    public function volunteers()
    {
        return $this->hasMany(ProjectVolunteer::class);
    }

    public function getStatusClassAttribute()
    {
        return [
            'planned' => 'secondary',
            'in_progress' => 'primary',
            'completed' => 'success',
            'postponed' => 'warning',
            'cancelled' => 'danger'
        ][$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        return [
            'planned' => 'Planifié',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'postponed' => 'Reporté',
            'cancelled' => 'Annulé'
        ][$this->status] ?? $this->status;
    }

    public static function active()
    {
        return self::where('status', 'in_progress');
    }
}