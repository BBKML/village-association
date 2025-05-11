<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($validated);

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $gallery = $event->gallery()->create([
                'title' => "Galerie pour {$event->title}",
                'description' => "Galerie automatiquement créée pour l'événement {$event->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.events.index')
                        ->with('success', 'Événement créé avec succès!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $gallery = $event->gallery ?? $event->gallery()->create([
                'title' => "Galerie pour {$event->title}",
                'description' => "Galerie automatiquement créée pour l'événement {$event->title}",
            ]);

            foreach ($request->file('gallery_images') as $image) {
                $gallery->media()->create([
                    'path' => $image->store("galleries/{$gallery->id}", 'public'),
                    'mime_type' => $image->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('admin.events.index')
                        ->with('success', 'Événement mis à jour avec succès!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete associated image
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        // Delete associated gallery and media if exists
        if ($event->gallery) {
            foreach ($event->gallery->media as $media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
            $event->gallery->delete();
        }

        $event->delete();

        return redirect()->route('admin.events.index')
                        ->with('success', 'Événement supprimé avec succès!');
    }
}