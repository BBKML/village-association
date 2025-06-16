<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Affiche la page des paramètres
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Met à jour les paramètres du site
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // Ajouter en haut du fichier

// Modifier la méthode update
    public function update(Setting $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::where('key', 'logo')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }
            
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => $this->determineType($value)]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Paramètres mis à jour avec succès');
    }

// Ajouter une nouvelle méthode privée
    private function determineType($value): string
    {
        if (is_bool($value)) return 'boolean';
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) return 'email';
        if (filter_var($value, FILTER_VALIDATE_URL)) return 'url';
        return 'string';
    }
}