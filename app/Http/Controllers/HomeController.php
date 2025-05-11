<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Event;
use App\Models\Activity;
use App\Models\Project;
use App\Models\History;
use App\Models\LocalService;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Dernières actualités publiées (3 maximum)
        $latestNews = News::where('is_published', true)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Événements à venir (3 maximum)
        $upcomingEvents = Event::where('end_date', '>=', Carbon::now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        // Activités récentes (3 maximum)
        $latestActivities = Activity::where('date', '<=', Carbon::now())
            ->orderBy('date', 'desc')
            ->take(3)
            ->get();

        // Projets en cours ou récents
        $featuredProjects = Project::whereIn('status', ['en_cours', 'termine'])
            ->orderBy('start_date', 'desc')
            ->take(3)
            ->get();

        // Services locaux mis en avant
        $featuredServices = LocalService::inRandomOrder()
            ->take(6)
            ->get();

        // Histoire de l'association
        $history = History::first();

        return view('home', [
            'latestNews' => $latestNews,
            'upcomingEvents' => $upcomingEvents,
            'latestActivities' => $latestActivities,
            'featuredProjects' => $featuredProjects,
            'featuredServices' => $featuredServices,
            'history' => $history
        ]);
    }
}