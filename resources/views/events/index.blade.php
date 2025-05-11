@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Événements</h1>
        <a href="{{ route('events.calendar') }}" class="btn btn-outline-secondary">
            <i class="far fa-calendar-alt"></i> Vue calendrier
        </a>
    </div>
    
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded-start h-100" alt="{{ $event->title }}" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <p class="text-muted mb-1">
                                    <i class="far fa-calendar-alt"></i> 
                                    {{ $event->start_date->format('d/m/Y H:i') }}
                                    @if($event->end_date)
                                        - {{ $event->end_date->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                                <p class="text-muted">
                                    <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                </p>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection