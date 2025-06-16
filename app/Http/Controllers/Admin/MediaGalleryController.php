<?php
// app/Http/Controllers/Admin/MediaGalleryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaGallery;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MediaGalleryController extends Controller
{
    /**
     * Affiche la liste des galeries
     */
    public function index()
    {
        $galleries = MediaGallery::withCount('items')->latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Enregistre une nouvelle galerie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:activity,project,event,other',
            'related_id' => 'nullable|integer',
            'related_type' => 'nullable|string|required_with:related_id',
        ]);

        $gallery = MediaGallery::create($validated);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Galerie créée avec succès');
    }

    /**
     * Affiche une galerie spécifique
     */
    public function show(MediaGallery $gallery)
    {
        $gallery->load(['items' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Affiche le formulaire d'édition d'une galerie
     */
// Modifier la méthode edit pour utiliser l'injection de modèle
    public function edit(MediaGallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    // Ajouter dans la méthode destroy


    /**
     * Met à jour une galerie
     */
    public function update(Request $request, MediaGallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:activity,project,event,other',
            'related_id' => 'nullable|integer',
            'related_type' => 'nullable|string|required_with:related_id',
        ]);

        $gallery->update($validated);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Galerie mise à jour avec succès');
    }

    /**
     * Upload des médias dans une galerie
     */
    public function upload(Request $request, MediaGallery $gallery)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov|max:5120',
        ]);

        $lastOrder = $gallery->items()->max('order') ?? 0;

        foreach ($request->file('files') as $file) {
            $path = $file->store("galleries/{$gallery->id}", 'public');

            $gallery->items()->create([
                'file_path' => $path,
                'file_type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video',
                'caption' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'order' => ++$lastOrder,
            ]);
        }

        return back()->with('success', 'Fichiers téléchargés avec succès');
    }

    /**
     * Supprime une galerie et tous ses médias
     */
    public function destroy(MediaGallery $gallery)
    {
        DB::transaction(function () use ($gallery) {
            $gallery->items->each(function ($item) {
                Storage::disk('public')->delete($item->file_path);
            });
            $gallery->delete();
        });

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galerie supprimée avec succès');
    }
}
