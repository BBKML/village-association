<?php
// app/Http/Controllers/Admin/HistoryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHistoryController extends Controller
{
    /**
     * Affiche le formulaire d'édition
     */
    public function edit(History $history)
    {
        return view('admin.histories.edit', compact('history'));
    }

    /**
     * Met à jour l'historique
     */
    public function update(Request $request, History $history)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'founder_name' => 'nullable|string|max:255',
            'founder_description' => 'nullable|string',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($history->image) {
                Storage::delete('public/' . $history->image);
            }
            
            // Stocke la nouvelle image
            $path = $request->file('image')->store('public/histories');
            $validated['image'] = str_replace('public/', '', $path);
        }

        $history->update($validated);

        return redirect()->route('admin.histories.edit', $history)
            ->with('success', 'Historique mis à jour avec succès');
    }
}