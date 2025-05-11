<?php
// app/Http/Controllers/Admin/MediaGalleryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaGallery;
use App\Models\MediaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'related_id' => 'nullable|integer'
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
        $gallery->load('items');
        return view('admin.galleries.show', compact('gallery'));
    }

    /**
     * Upload des médias dans une galerie
     */
    public function upload(Request $request, MediaGallery $gallery)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,mov|max:5120'
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store("public/galleries/{$gallery->id}");
            
            $gallery->items()->create([
                'file_path' => str_replace('public/', '', $path),
                'file_type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video',
                'caption' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            ]);
        }

        return back()->with('success', 'Fichiers téléchargés avec succès');
    }

    /**
     * Supprime un média
     */
    public function destroyMedia(MediaItem $media)
    {
        Storage::delete('public/' . $media->file_path);
        $media->delete();
        
        return back()->with('success', 'Média supprimé avec succès');
    }

    /**
     * Supprime une galerie
     */
    public function destroy(MediaGallery $gallery)
    {
        // Supprime tous les fichiers associés
        foreach ($gallery->items as $item) {
            Storage::delete('public/' . $item->file_path);
        }
        
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galerie supprimée avec succès');
    }
}