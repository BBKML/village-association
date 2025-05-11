@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="activity-detail">
                <h1>{{ $activity->title }}</h1>
                <div class="meta mb-4">
                    <span class="date"><i class="far fa-calendar-alt"></i> {{ $activity->date->format('d/m/Y') }}</span>
                    <span class="location ml-3"><i class="fas fa-map-marker-alt"></i> {{ $activity->location }}</span>
                </div>
                
                <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="img-fluid rounded mb-4">
                
                <div class="description mb-5">
                    {!! $activity->description !!}
                </div>

                @if($activity->gallery && $activity->gallery->items->count() > 0)
                    <div class="gallery-section mb-5">
                        <h3>Galerie photos</h3>
                        <div class="row">
                            @foreach($activity->gallery->items as $item)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" data-lightbox="activity-gallery">
                                        <img src="{{ asset('storage/' . $item->file_path) }}" class="img-thumbnail" alt="{{ $item->caption }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection