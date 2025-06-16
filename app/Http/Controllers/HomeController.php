<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\News;
use App\Models\Event;
use App\Models\Project;
use App\Models\Member;
use App\Models\MediaGallery;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil du site
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupération des données principales
        $association = Association::with('mediaGallery')->first();
        
        // Actualités - seulement les publiées
        $latestNews = News::where('is_published', true)
                         ->latest('published_at')
                         ->take(3)
                         ->get();

        // Événements à venir
        $upcomingEvents = Event::where('start_date', '>=', now())
                             ->orderBy('start_date')
                             ->take(3)
                             ->get();

        // Projets en cours
        $ongoingProjects = Project::where('status', 'in_progress')
                                ->latest()
                                ->take(2)
                                ->get();

        // Membres du bureau
        $boardMembers = Member::where('is_board_member', true)
                            ->orderBy('order')
                            ->take(4)
                            ->get();

        // Galeries avec au moins un élément
        $galleries = MediaGallery::with(['items' => function($query) {
                            $query->orderBy('order')->take(1);
                        }])
                        ->withCount('items')
                        ->whereHas('items')
                        ->latest()
                        ->take(6)
                        ->get();

        return view('home', [
            'association' => $association,
            'latestNews' => $latestNews,
            'upcomingEvents' => $upcomingEvents,
            'ongoingProjects' => $ongoingProjects,
            'boardMembers' => $boardMembers,
            'galleries' => $galleries
        ]);
    }
}