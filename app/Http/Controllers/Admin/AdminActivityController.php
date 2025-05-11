<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::latest()->paginate(10);
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity = Activity::create($validated);

        // Create a gallery for this activity if images were uploaded
        if ($request->hasFile('gallery_images')) {
            $gallery = $activity->gallery()->create([
                'title' => "Galerie pour {$activity->title}",
                'description' => "Galerie automatiquement créée pour l'activité {$activity->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité créée avec succès!');
    }

    /**
     * Display the specified activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity->update($validated);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $gallery = $activity->gallery ?? $activity->gallery()->create([
                'title' => "Galerie pour {$activity->title}",
                'description' => "Galerie automatiquement créée pour l'activité {$activity->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité mise à jour avec succès!');
    }

    /**
     * Remove the specified activity from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        // Delete associated image
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        // Delete associated gallery and media if exists
        if ($activity->gallery) {
            foreach ($activity->gallery->media as $media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
            $activity->gallery->delete();
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité supprimée avec succès!');
    }
}