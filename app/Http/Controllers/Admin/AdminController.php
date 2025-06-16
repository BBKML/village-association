<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Project;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'news' => News::count(),
            'events' => Event::upcoming()->count(),
            'projects' => Project::active()->count(),
            'messages' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::unread()->count(),
        ];

        $latestMessages = ContactMessage::latest()->take(5)->get();
        
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact('stats', 'latestMessages', 'recentActivities'));
    }

    protected function getRecentActivities()
    {
        // Implémentez la logique pour récupérer les activités récentes
        // Cela pourrait être un mélange d'événements, d'actualités, de messages, etc.
        return [
            [
                'icon' => 'newspaper',
                'color' => 'blue',
                'title' => 'Nouvelle actualité publiée',
                'description' => 'Préparation de la fête annuelle du village',
                'date' => now()->subHours(2)
            ],
            [
                'icon' => 'calendar-plus',
                'color' => 'green',
                'title' => 'Nouvel événement ajouté',
                'description' => 'Réunion du conseil - 15 mai 2025',
                'date' => now()->subDays(1)
            ],
            // Ajoutez d'autres activités selon votre logique métier
        ];
    }

    // ... autres méthodes
}