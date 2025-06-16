<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Affiche la page publique pour rejoindre l'association
     */
    public function join()
    {
        return view('membership.join');
    }

    /**
     * Affiche la liste des membres (admin)
     */
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Stocke un nouveau membre
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'joined_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_board_member' => 'nullable|boolean'
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        // Conversion de la checkbox en booléen
        $validated['is_board_member'] = $request->has('is_board_member');

        // Création du membre
        Member::create($validated);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Membre créé avec succès');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Met à jour un membre existant
     */
    public function update(Request $request, Member $member)
    {
        // Validation des données
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255|unique:members,email,'.$member->id,
            'phone' => 'nullable|string|max:20',
            'joined_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_board_member' => 'nullable|boolean'
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($member->image) {
                Storage::disk('public')->delete($member->image);
            }
            $validated['image'] = $request->file('image')->store('members', 'public');
        }

        // Conversion de la checkbox en booléen
        $validated['is_board_member'] = $request->has('is_board_member');

        // Mise à jour du membre
        $member->update($validated);

        return redirect()->route('admin.members.index')
                         ->with('success', 'Membre mis à jour avec succès');
    }

    /**
     * Supprime un membre
     */
    public function destroy(Member $member)
    {
        // Suppression de l'image si elle existe
        if ($member->image) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('admin.members.index')
                         ->with('success', 'Membre supprimé avec succès');
    }
}