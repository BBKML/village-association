<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:min_width=100,min_height=100',

            'is_published' => 'required|boolean',
            'is_featured' => 'nullable|boolean' 
        ]);
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        if ($request->hasFile('image')) {
            // Génération d'un nom unique pour l'image
            $imageName = time().'_'.Str::slug($request->title).'.'.$request->image->extension();
            
            // Stockage dans public/storage/news
            $path = $request->image->storeAs('news', $imageName, 'public');
            
            // Correction: pas de commentaire erroné
            $validated['image'] = 'news/'.$imageName;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité créée avec succès');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
           
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:min_width=100,min_height=100',
            'is_published' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'remove_image' => 'nullable|boolean'
        ]);
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        // Suppression de remove_image du tableau validated car ce n'est pas un champ du modèle
        if (isset($validated['remove_image'])) {
            unset($validated['remove_image']);
        }

        // Gestion de la suppression d'image
        if ($request->has('remove_image') && $request->remove_image) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = null;
        }

        // Gestion du nouvel upload
        if ($request->hasFile('image')) {
            // Suppression de l'ancienne image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            // Génération d'un nom unique pour la nouvelle image
            $imageName = time().'_'.Str::slug($request->title).'.'.$request->image->extension();
            $path = $request->image->storeAs('news', $imageName, 'public');
            $validated['image'] = 'news/'.$imageName;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité mise à jour avec succès');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Actualité supprimée avec succès');
    }

    public function togglePublish(News $news)
    {
        $news->update([
            'is_published' => !$news->is_published
        ]);

        return back()->with('success', 'Statut de publication mis à jour');
    }
}