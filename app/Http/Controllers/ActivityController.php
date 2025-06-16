<?php

// app/Http/Controllers/ActivityController.php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Association;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();
        
        // Filtrage par catégorie
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }
        
        // Filtrage par date
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
            }
        }
        
        // Récupérer les catégories uniques pour le filtre
        $categories = Activity::distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->filter()
            ->sort();
        
        // Récupérer les activités avec pagination
        $activities = $query->orderBy('date', 'desc')->paginate(9);
        
        // Récupérer les informations de l'association (si nécessaire)
        $association = Association::first();
        
        return view('activities.index', compact('activities', 'categories', 'association'));
    }

    public function show(Activity $activity)
    {
        // Récupérer les activités liées (même catégorie, mais pas l'activité actuelle)
        $relatedActivities = Activity::where('id', '!=', $activity->id)
            ->when($activity->category, function ($query) use ($activity) {
                return $query->where('category', $activity->category);
            })
            ->upcoming()
            ->take(3)
            ->get();
        
        // Si pas assez d'activités liées, compléter avec d'autres activités
        if ($relatedActivities->count() < 3) {
            $additionalActivities = Activity::where('id', '!=', $activity->id)
                ->whereNotIn('id', $relatedActivities->pluck('id'))
                ->latest('date')
                ->take(3 - $relatedActivities->count())
                ->get();
            
            $relatedActivities = $relatedActivities->concat($additionalActivities);
        }
        
        // Récupérer les informations de l'association
        $association = Association::first();
            
        return view('activities.show', compact('activity', 'relatedActivities', 'association'));
    }
}