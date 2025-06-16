<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaItemController extends Controller
{
    /**
     * Affiche le formulaire d'édition d'un média
     */
public function edit(MediaItem $media)
{
    // Supposons qu’un média appartient à une galerie
    $gallery = $media->gallery;

    // Vérification de l'existence de la galerie (facultatif mais conseillé)
    if (!$gallery) {
        abort(404, 'Galerie non trouvée');
    }

    return view('admin.media.edit', compact('media', 'gallery'));
}

    /**
     * Met à jour les informations d'un média
     */
    public function update(Request $request, MediaItem $media)
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $media->update($validated);

        return redirect()->route('admin.galleries.show', $media->gallery_id)
            ->with('success', 'Média mis à jour avec succès');
    }

    /**
     * Supprime un média
     */
    public function destroy(MediaItem $media)
    {
        $galleryId = $media->gallery_id;

        $media->delete();

        return redirect()->route('admin.galleries.show', $galleryId)
            ->with('success', 'Média supprimé avec succès');
    }

    /**
     * Change l'ordre des médias dans une galerie
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*' => 'integer|exists:media_items,id'
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $index => $id) {
                MediaItem::where('id', $id)->update(['order' => $index + 1]);
            }
        });

        return response()->json(['success' => true]);
    }

    /**
     * Affiche un média spécifique avec navigation (version simple)
     */
// Modifier la méthode show
    public function show(MediaItem $media)
    {
        $media->load(['gallery.items' => function($query) {
            $query->orderBy('order');
        }]);

        $items = $media->gallery->items;
        $currentIndex = $items->search(fn($item) => $item->id === $media->id);

        return view('admin.media.show', [
            'media' => $media,
            'prevItem' => $items[$currentIndex - 1] ?? null,
            'nextItem' => $items[$currentIndex + 1] ?? null
        ]);
    }
}
