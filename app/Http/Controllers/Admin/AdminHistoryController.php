<?php
// app/Http/Controllers/Admin/AdminHistoryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminHistoryController extends Controller
{
    /**
     * Affiche la liste des historiques
     */
    public function index()
    {
        $histories = History::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.history.index', compact('histories'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.history.create');
    }

    /**
     * Stocke un nouvel historique
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'founder_name' => 'nullable|string|max:255',
            'founder_description' => 'nullable|string|max:1000'
        ]);

        // Génération du slug unique
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        
        while (History::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('history', 'public');
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Erreur lors du téléchargement de l\'image: ' . $e->getMessage()]);
            }
        }

        History::create($validated);

        return redirect()->route('admin.history.index')
            ->with('success', 'Historique créé avec succès');
    }

    /**
     * Affiche un historique spécifique
     */
    public function show(History $history)
    {
        return view('admin.history.show', compact('history'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(History $history)
    {
        return view('admin.history.edit', compact('history'));
    }

    /**
     * Met à jour l'historique
     */
    public function update(Request $request, History $history)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'founder_name' => 'nullable|string|max:255',
            'founder_description' => 'nullable|string|max:1000',
            'remove_image' => 'nullable|boolean'
        ]);

        // Génération du slug unique si le titre a changé
        if ($history->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (History::where('slug', $slug)->where('id', '!=', $history->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        // Gestion de la suppression d'image
        if ($request->has('remove_image') && $request->remove_image) {
            if ($history->image && Storage::exists('public/' . $history->image)) {
                Storage::delete('public/' . $history->image);
            }
            $validated['image'] = null;
        }

        // Gestion du téléchargement d'une nouvelle image
        if ($request->hasFile('image')) {
            try {
                // Supprime l'ancienne image si elle existe
                if ($history->image && Storage::exists('public/' . $history->image)) {
                    Storage::delete('public/' . $history->image);
                }
                
                // Stocke la nouvelle image
                $path = $request->file('image')->store('history', 'public');
                $validated['image'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Erreur lors du téléchargement de l\'image: ' . $e->getMessage()]);
            }
        }

        $history->update($validated);

        return redirect()->route('admin.history.index')
            ->with('success', 'Historique mis à jour avec succès');
    }

    /**
     * Supprime un historique
     */
    public function destroy(History $history)
    {
        try {
            if ($history->image && Storage::exists('public/' . $history->image)) {
                Storage::delete('public/' . $history->image);
            }
            
            $history->delete();

            return redirect()->route('admin.history.index')
                ->with('success', 'Historique supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.history.index')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}