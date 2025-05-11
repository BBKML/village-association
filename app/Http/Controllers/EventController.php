<?php

// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('start_date', '>=', now())
                    ->orderBy('start_date')
                    ->paginate(10);
        return view('events.index', compact('events'));
    }

    public function calendar()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'url' => route('events.show', $event->id),
                'description' => $event->description,
            ];
        });

        return view('events.calendar', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}
