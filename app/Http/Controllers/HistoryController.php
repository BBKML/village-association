<?php

// app/Http/Controllers/HistoryController.php
namespace App\Http\Controllers;

use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $history = History::first();
        return view('history.index', compact('history'));
    }
}
