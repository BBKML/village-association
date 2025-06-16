<?php
// app/Http/Controllers/HistoryController.php
namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::orderBy('created_at', 'desc')->get();
        
        // Données pour la timeline (optionnel)
        $timeline = [
            ['year' => '2020', 'title' => 'Fondation', 'event' => 'Création de l\'association'],
            ['year' => '2021', 'title' => 'Premier projet', 'event' => 'Lancement du premier projet communautaire'],
            // Ajoutez d'autres événements selon vos besoins
        ];
        
        return view('history.index', compact('histories', 'timeline'));
    }
    
    public function show($slug)
    {
        $history = History::where('slug', $slug)->firstOrFail();
        return view('history.show', compact('history'));
    }
}