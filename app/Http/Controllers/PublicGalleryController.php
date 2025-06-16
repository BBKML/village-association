<?php
namespace App\Http\Controllers;

use App\Models\MediaGallery;

class PublicGalleryController extends Controller
{
    public function index()
    {
        $galleries = MediaGallery::withCount('items')
                       ->whereHas('items')
                       ->latest()
                       ->paginate(12);
        
        return view('galleries.index', compact('galleries'));
    }

    public function show(MediaGallery $gallery)
    {
        $gallery->load(['items' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('galleries.show', compact('gallery'));
    }
}