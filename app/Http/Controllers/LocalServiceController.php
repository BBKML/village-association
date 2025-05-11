<?php

// app/Http/Controllers/LocalServiceController.php
namespace App\Http\Controllers;

use App\Models\LocalService;
use Illuminate\Http\Request;

class LocalServiceController extends Controller
{
    public function index()
    {
        $services = LocalService::orderBy('name')->paginate(10);
        return view('services.index', compact('services'));
    }

    public function show(LocalService $service)
    {
        return view('services.show', compact('service'));
    }
}