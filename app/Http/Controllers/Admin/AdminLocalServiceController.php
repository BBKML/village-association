<?php
// app/Http/Controllers/Admin/LocalServiceController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLocalServiceController extends Controller
{
    /**
     * Affiche la liste des services
     */
    public function index()
    {
        $services = LocalService::orderBy('name')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Enregistre un nouveau service
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:commerçant,artisan,médical,école,autre',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/services');
            $validated['image'] = str_replace('public/', '', $path);
        }

        LocalService::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès');
    }

    /**
     * Affiche les détails d'un service
     */
    public function show(LocalService $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(LocalService $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Met à jour un service
     */
    public function update(Request $request, LocalService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:commerçant,artisan,médical,école,autre',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($service->image) {
                Storage::delete('public/' . $service->image);
            }
            
            $path = $request->file('image')->store('public/services');
            $validated['image'] = str_replace('public/', '', $path);
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès');
    }

    /**
     * Supprime un service
     */
    public function destroy(LocalService $service)
    {
        if ($service->image) {
            Storage::delete('public/' . $service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès');
    }
}