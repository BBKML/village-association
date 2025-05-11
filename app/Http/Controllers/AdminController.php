<?php

// app/Http/Controllers/Admin/AdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\News;
use App\Models\Project;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'messages' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'upcomingEvents' => Event::where('start_date', '>=', now())->count(),
            'publishedNews' => News::where('is_published', true)->count(),
            'activeProjects' => Project::where('status', 'in_progress')->count(),
        ];

        $latestMessages = ContactMessage::latest()->take(5)->get();
        $latestProjects = Project::latest()->take(3)->get();

        return view('admin.dashboard', compact('stats', 'latestMessages', 'latestProjects'));
    }
}