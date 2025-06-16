{{-- resources/views/events/past.blade.php --}}
@extends('layouts.app')

@section('title', 'Événements passés')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Événements passés</h1>

    @if($events->isEmpty())
        <div class="alert alert-info">Aucun événement archivé.</div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="text-muted">
                                <i class="fas fa-calendar-alt"></i> {{ $event->start_date->format('d/m/Y') }}
                            </p>
                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection