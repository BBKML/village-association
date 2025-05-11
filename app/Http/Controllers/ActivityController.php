<?php

// app/Http/Controllers/ActivityController.php
namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderBy('date', 'desc')->paginate(10);
        return view('activities.index', compact('activities'));
    }

    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }
}
