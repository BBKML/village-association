<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index()
    {
        $activities = Activity::latest()->paginate(10);
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'available_spots' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // Gestion de l'image principale
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('activities', 'public');
            }

            // Gestion du checkbox is_featured
            $validated['is_featured'] = $request->has('is_featured');

            // Création de l'activité
            $activity = Activity::create($validated);

            // Gestion de la galerie d'images
            if ($request->hasFile('gallery_images')) {
                $gallery = $activity->gallery()->create([
                    'title' => "Galerie pour {$activity->title}",
                    'description' => "Galerie automatiquement créée pour l'activité {$activity->title}",
                    'type' => 'activity',
                ]);

                foreach ($request->file('gallery_images') as $index => $image) {
                    $path = $image->store("galleries/{$gallery->id}", 'public');
                    $gallery->items()->create([
                        'file_path' => $path,
                        'file_type' => str_starts_with($image->getMimeType(), 'image') ? 'image' : 'file',
                        'caption' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                        'order' => $index + 1
                    ]);
                }
            }

            return redirect()->route('admin.activities.index')
                ->with('success', 'Activité créée avec succès!');
        });
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'time' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'available_spots' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated, $activity) {
            // Gestion de l'image principale
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                    Storage::disk('public')->delete($activity->image);
                }
                $validated['image'] = $request->file('image')->store('activities', 'public');
            }

            // Gestion du checkbox is_featured
            $validated['is_featured'] = $request->has('is_featured');

            // Mise à jour de l'activité
            $activity->update($validated);

            // Gestion de la galerie d'images
            if ($request->hasFile('gallery_images')) {
                // Créer la galerie si elle n'existe pas
                $gallery = $activity->gallery;
                if (!$gallery) {
                    $gallery = $activity->gallery()->create([
                        'title' => "Galerie pour {$activity->title}",
                        'description' => "Galerie automatiquement créée pour l'activité {$activity->title}",
                        'type' => 'activity',
                    ]);
                }

                // Obtenir le dernier ordre
                $lastOrder = $gallery->items()->max('order') ?? 0;
                
                foreach ($request->file('gallery_images') as $image) {
                    $path = $image->store("galleries/{$gallery->id}", 'public');
                    $gallery->items()->create([
                        'file_path' => $path,
                        'file_type' => str_starts_with($image->getMimeType(), 'image') ? 'image' : 'file',
                        'caption' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                        'order' => ++$lastOrder,
                    ]);
                }
            }

            return redirect()->route('admin.activities.index')
                ->with('success', 'Activité mise à jour avec succès!');
        });
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity)
    {
        return DB::transaction(function () use ($activity) {
            // Supprimer l'image principale
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            // Supprimer les images de la galerie
            if ($activity->gallery) {
                foreach ($activity->gallery->items as $item) {
                    if (Storage::disk('public')->exists($item->file_path)) {
                        Storage::disk('public')->delete($item->file_path);
                    }
                }
                $activity->gallery->delete();
            }

            $activity->delete();

            return redirect()->route('admin.activities.index')
                ->with('success', 'Activité supprimée avec succès!');
        });
    }
}