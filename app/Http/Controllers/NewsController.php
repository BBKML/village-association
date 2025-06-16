<?php

// app/Http/Controllers/NewsController.php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Project;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->paginate(10);
                
        $featuredNews = News::where('is_featured', true)
                        ->where('is_published', true)  // <- AJOUTER cette condition
                        ->latest('published_at')
                        ->take(3)  // Limiter le nombre
                        ->get();
        
        $ongoingCount = Project::where('status', 'in_progress')->count();
        $completedCount = Project::where('status', 'completed')->count();
                
        return view('news.index', compact('news', 'featuredNews', 'ongoingCount', 'completedCount'));
    }

    public function show(News $news)
    {
        // Vérifier que l'article est publié (sauf pour les admins)
        if (!$news->is_published && !auth()->check()) {
            abort(404);
        }
        
        $relatedNews = News::where('is_published', true)
                        ->where('id', '!=', $news->id)
                        ->latest('published_at')
                        ->take(5)
                        ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }

}
