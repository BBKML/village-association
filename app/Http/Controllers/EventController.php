<?php

// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        Log::info('Récupération des événements à venir');
        $events = Event::upcoming()->paginate(9);
        Log::info('Nombre d\'événements trouvés : ' . $events->count());
        Log::info('Événements : ' . $events->toJson());
        
        return view('events.index', compact('events'));
    }

    public function calendar()
    {
        $formattedEvents = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'url' => route('events.show', $event->id),
                'description' => Str::limit($event->description, 100),
                'backgroundColor' => $event->color ?? '#3788d8',
                'borderColor' => $event->color ?? '#3788d8',
                'textColor' => '#ffffff'
            ];
        });

        return view('events.calendar', compact('formattedEvents'));
    }

    public function show(Event $event)
    {
        $event->load('gallery');
        $event->load('gallery.items');
        $relatedEvents = Event::where('id', '!=', $event->id)
            ->where(function($query) use ($event) {
                $query->whereBetween('start_date', [$event->start_date, $event->end_date])
                    ->orWhereBetween('end_date', [$event->start_date, $event->end_date]);
            })
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    public function past()
    {
        $events = Event::past()->paginate(9);
        return view('events.past', compact('events'));
    }
}