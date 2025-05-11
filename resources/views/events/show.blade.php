@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="event-detail">
                <h1>{{ $event->title }}</h1>
                
                <div class="meta mb-4">
                    <span class="date">
                        <i class="far fa-calendar-alt"></i> 
                        {{ $event->start_date->format('d/m/Y H:i') }}
                        @if($event->end_date)
                            - {{ $event->end_date->format('d/m/Y H:i') }}
                        @endif
                    </span>
                    <span class="location ms-3">
                        <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                    </span>
                </div>
                
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-4">
                @endif
                
                <div class="description mb-4">
                    {!! $event->description !!}
                </div>
                
                @if($event->gallery && $event->gallery->items->count() > 0)
                    <div class="gallery-section mb-5">
                        <h3>Galerie photos</h3>
                        <div class="row">
                            @foreach($event->gallery->items as $item)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" data-lightbox="event-gallery" data-title="{{ $item->caption }}">
                                        <img src="{{ asset('storage/' . $item->file_path) }}" class="img-thumbnail" alt="{{ $item->caption }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="event-actions mt-4">
                    <a href="#" class="btn btn-success">S'inscrire à l'événement</a>
                    <a href="{{ route('events.calendar') }}" class="btn btn-outline-primary ms-2">
                        <i class="far fa-calendar-alt"></i> Voir le calendrier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection