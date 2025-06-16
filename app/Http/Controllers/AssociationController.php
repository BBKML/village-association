<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Member;
use App\Models\Activity;
use App\Models\Project;

class AssociationController extends Controller
{
    public function about()
    {
        $association = Association::firstOrFail();
        $boardMembers = Member::boardMembers()
            ->orderBy('joined_date')
            ->get();
        
        return view('association.about', compact('association', 'boardMembers'));
    }

    public function members()
    {
        $members = Member::orderBy('joined_date', 'desc')->paginate(12);
        return view('association.members', compact('members'));
    }

    public function activities()
    {
        $activities = Activity::orderBy('date', 'desc')->paginate(10);
        return view('association.activities', compact('activities'));
    }

    public function projects()
    {
        $projects = Project::orderBy('start_date', 'desc')->paginate(10);
        return view('association.projects', compact('projects'));
    }
    public function objectives()
    {
        $association = Association::firstOrFail();
        return view('association.objectives', compact('association'));
    }
    // Ajoute ces méthodes au contrôleur existant
    public function gallery()
    {
        $association = Association::with(['mediaGallery.mediaItems' => function($query) {
            $query->orderBy('order');
        }])->firstOrFail();

        return view('association.gallery', compact('association'));
    }

    public function boardMembers()
    {
        $association = Association::firstOrFail();


        return view('association.board-members', compact('association', 'boardMembers'));
    }
}