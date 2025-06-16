<?php

// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('start_date', 'desc')->paginate(10);
        $projectsCount = Project::count();
        $ongoingCount = Project::where('status', 'in_progress')->count();
        $completedCount = Project::where('status', 'completed')->count();
        
        return view('projects.index', compact('projects', 'projectsCount', 'ongoingCount', 'completedCount'));
    }

    public function show($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            $relatedProjects = Project::where('id', '!=', $id)
                                    ->orderBy('start_date', 'desc')
                                    ->take(3)
                                    ->get();

            return view('projects.show', compact('project', 'relatedProjects'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Projet non trouvé');
        }
    }

    public function volunteer(Project $project)
    {
        if (!$project->needs_volunteers) {
            return redirect()->back()->with('error', 'Ce projet ne recherche pas de bénévoles actuellement');
        }

        return view('projects.volunteer', compact('project'));
    }

    public function donate(Project $project)
    {
        if (!$project->needs_donations) {
            return redirect()->back()->with('error', 'Ce projet ne recherche pas de dons actuellement');
        }

        return view('projects.donate', compact('project'));
    }

    public function storeVolunteer(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'skills' => 'nullable|string'
        ]);

        $project->volunteers()->create($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Votre candidature a été envoyée!');
    }
}