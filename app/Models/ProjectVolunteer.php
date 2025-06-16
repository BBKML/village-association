<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectVolunteer extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'email',
        'phone',
        'skills',
        'status' // 'pending', 'accepted', 'rejected'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}