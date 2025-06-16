<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MediaGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
// Ajouter en haut du fichier

// Modifier la méthode store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        return DB::transaction(function () use ($request, $validated) {
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('events', 'public');
            }

            $event = Event::create($validated);

            if ($request->hasFile('gallery_images')) {
                $gallery = $event->gallery()->create([
                    'title' => "Galerie pour {$event->title}",
                    'description' => "Galerie pour l'événement {$event->title}",
                    'type' => 'event'
                ]);

                foreach ($request->file('gallery_images') as $image) {
                    $path = $image->store("galleries/{$gallery->id}", 'public');
                    $gallery->items()->create([
                        'file_path' => $path,
                        'file_type' => str_starts_with($image->getMimeType(), 'image') ? 'image' : 'video',
                        'caption' => $image->getClientOriginalName(),
                        'order' => $gallery->items()->max('order') + 1
                    ]);
                }
            }

            return redirect()->route('admin.events.index')
                ->with('success', 'Événement créé avec succès!');
        });
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
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
                    'type' => 'event'
                ]);

            foreach ($request->file('gallery_images') as $image) {
            $gallery->items()->create([
                'file_path' => $image->store("galleries/{$gallery->id}", 'public'),
                'file_type' => str_starts_with($image->getMimeType(), 'image') ? 'image' : 'video',
                'caption' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                'order' => $gallery->items()->max('order') + 1
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
            // CORRECTION: Remplacer media par items
            foreach ($event->gallery->items as $item) {
                Storage::disk('public')->delete($item->file_path);
                $item->delete();
            }
            $event->gallery->delete();
        }

        $event->delete();

        return redirect()->route('admin.events.index')
                        ->with('success', 'Événement supprimé avec succès!');
    }
}