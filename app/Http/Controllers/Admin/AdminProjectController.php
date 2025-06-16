<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\MediaGallery;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        try {
            Log::info('Début de la création du projet', ['request' => $request->all()]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'status' => 'required|in:planned,in_progress,completed,postponed,cancelled',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'needs_volunteers' => 'boolean',
                'needs_donations' => 'boolean',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            Log::info('Données validées', ['validated' => $validated]);

            // Gestion de l'image principale
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects', 'public');
                $validated['image'] = $imagePath;
                Log::info('Image principale stockée', ['path' => $imagePath]);
            }

            // Conversion des checkbox en boolean
            $validated['needs_volunteers'] = $request->has('needs_volunteers');
            $validated['needs_donations'] = $request->has('needs_donations');

            Log::info('Données avant création', ['data' => $validated]);

            // Création du projet
            $project = Project::create($validated);
            Log::info('Projet créé', ['project' => $project->toArray()]);

            // Gestion de la galerie d'images
            if ($request->hasFile('gallery_images')) {
                $gallery = $project->gallery()->create([
                    'title' => 'Galerie du projet ' . $project->title,
                    'type' => 'project'
                ]);

                foreach ($request->file('gallery_images') as $image) {
                    $path = $image->store('galleries', 'public');
                    $fileType = str_starts_with($image->getMimeType(), 'image') ? 'image' : 'video';
                    
                    $gallery->items()->create([
                        'file_path' => $path,
                        'file_type' => $fileType,
                        'caption' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                    ]);
                }
                Log::info('Galerie créée', ['gallery' => $gallery->toArray()]);
            }

            return redirect()->route('admin.projects.index')
                ->with('success', 'Projet créé avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du projet', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la création du projet: ' . $e->getMessage()]);
        }
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
            'end_date' => 'nullable|date',
            'status' => 'required|in:planned,in_progress,completed,postponed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'needs_volunteers' => 'boolean',
            'needs_donations' => 'boolean',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

       
        // Dans la méthode update(), corriger :
        if ($request->has('remove_image') && $project->image) {
            Storage::disk('public')->delete($project->image);
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $imagePath = $request->file('image')->store('projects', 'public');
            $validated['image'] = $imagePath;
        }

        // Conversion des checkbox en boolean
        $validated['needs_volunteers'] = $request->has('needs_volunteers');
        $validated['needs_donations'] = $request->has('needs_donations');

        // Mise à jour du projet
        $project->update($validated);

        // Gestion de la galerie d'images
        if ($request->hasFile('gallery_images')) {
            $gallery = $project->gallery;
            if (!$gallery) {
                $gallery = $project->gallery()->create([
                    'title' => 'Galerie du projet ' . $project->title,
                    'type' => 'project'
                ]);
            }

            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('galleries', 'public');
                $fileType = str_starts_with($image->getMimeType(), 'image') ? 'image' : 'video';
                
                $gallery->items()->create([
                    'file_path' => $path,
                    'file_type' => $fileType,
                    'caption' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet mis à jour avec succès');
    }

    /**
     * Remove the specified project from storage.
     */
    // Modifier la méthode destroy
    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            if ($project->gallery) {
                $project->gallery->items->each(function ($item) {
                    Storage::disk('public')->delete($item->file_path);
                    $item->delete();
                });
                $project->gallery->delete();
            }

            $project->delete();
        });

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet supprimé avec succès!');
    }
}