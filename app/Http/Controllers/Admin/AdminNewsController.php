<?php
// app/Http/Controllers/Admin/NewsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    /**
     * Affiche la liste des actualités
     */
    public function index()
    {
        $news = News::latest()
                   ->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Enregistre une nouvelle actualité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'required|boolean'
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/news');
            $validated['image'] = str_replace('public/', '', $path);
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité créée avec succès');
    }

    /**
     * Affiche une actualité spécifique
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Met à jour une actualité
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'required|boolean',
            'remove_image' => 'nullable|boolean'
        ]);

        // Gestion de l'image
        if ($request->has('remove_image') && $request->remove_image && $news->image) {
            Storage::delete('public/' . $news->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($news->image) {
                Storage::delete('public/' . $news->image);
            }
            
            $path = $request->file('image')->store('public/news');
            $validated['image'] = str_replace('public/', '', $path);
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité mise à jour avec succès');
    }

    /**
     * Supprime une actualité
     */
    public function destroy(News $news)
    {
        // Supprime l'image associée si elle existe
        if ($news->image) {
            Storage::delete('public/' . $news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité supprimée avec succès');
    }

    /**
     * Change le statut de publication
     */
    public function togglePublish(News $news)
    {
        $news->update([
            'is_published' => !$news->is_published
        ]);

        return back()->with('success', 'Statut de publication mis à jour');
    }
}