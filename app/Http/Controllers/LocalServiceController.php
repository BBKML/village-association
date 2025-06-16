<?php

// app/Http/Controllers/LocalServiceController.php
namespace App\Http\Controllers;

use App\Models\LocalService;
use Illuminate\Http\Request;

class LocalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = LocalService::query();
        
        // Filtrage par type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        // Recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $services = $query->orderBy('name')->paginate(12);
        $types = LocalService::distinct()->pluck('type')->filter();
        
        return view('services.index', compact('services', 'types'));
    }
    public function show(LocalService $service)
    {
        return view('services.show', compact('service'));
    }
}