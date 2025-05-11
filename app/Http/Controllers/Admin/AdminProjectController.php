<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,in_progress,completed,postponed,cancelled',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'needs_volunteers' => 'boolean',
            'needs_donations' => 'boolean',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // Convert checkbox values to boolean
        $validated['needs_volunteers'] = $request->has('needs_volunteers');
        $validated['needs_donations'] = $request->has('needs_donations');

        $project = Project::create($validated);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $gallery = $project->gallery()->create([
                'title' => "Galerie pour {$project->title}",
                'description' => "Galerie automatiquement créée pour le projet {$project->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Projet créé avec succès!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,in_progress,completed,postponed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'needs_volunteers' => 'boolean',
            'needs_donations' => 'boolean',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // Convert checkbox values to boolean
        $validated['needs_volunteers'] = $request->has('needs_volunteers');
        $validated['needs_donations'] = $request->has('needs_donations');

        $project->update($validated);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $gallery = $project->gallery ?? $project->gallery()->create([
                'title' => "Galerie pour {$project->title}",
                'description' => "Galerie automatiquement créée pour le projet {$project->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Projet mis à jour avec succès!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Delete associated image
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        // Delete associated gallery and media if exists
        if ($project->gallery) {
            foreach ($project->gallery->media as $media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
            $project->gallery->delete();
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Projet supprimé avec succès!');
    }
}