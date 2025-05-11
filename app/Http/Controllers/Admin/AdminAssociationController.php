<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAssociationController extends Controller
{
    /**
     * Display a listing of the associations.
     */
    public function index()
    {
        $associations = Association::latest()->paginate(10);
        return view('admin.associations.index', compact('associations'));
    }

    /**
     * Show the form for creating a new association.
     */
    public function create()
    {
        return view('admin.associations.create');
    }

    /**
     * Store a newly created association in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('associations', 'public');
        }

        Association::create($validated);

        return redirect()->route('admin.associations.index')
                        ->with('success', 'Association créée avec succès!');
    }

    /**
     * Display the specified association.
     */
    public function show(Association $association)
    {
        return view('admin.associations.show', compact('association'));
    }

    /**
     * Show the form for editing the specified association.
     */
    public function edit(Association $association)
    {
        return view('admin.associations.edit', compact('association'));
    }

    /**
     * Update the specified association in storage.
     */
    public function update(Request $request, Association $association)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($association->main_image) {
                Storage::disk('public')->delete($association->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('associations', 'public');
        }

        $association->update($validated);

        return redirect()->route('admin.associations.index')
                        ->with('success', 'Association mise à jour avec succès!');
    }

    /**
     * Remove the specified association from storage.
     */
    public function destroy(Association $association)
    {
        if ($association->main_image) {
            Storage::disk('public')->delete($association->main_image);
        }

        $association->delete();

        return redirect()->route('admin.associations.index')
                        ->with('success', 'Association supprimée avec succès!');
    }
}