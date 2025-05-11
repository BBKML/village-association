@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Nos Activités</h1>
    
    <div class="row">
        @foreach($activities as $activity)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $activity->image) }}" class="card-img-top" alt="{{ $activity->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $activity->title }}</h5>
                        <p class="card-text">{{ Str::limit($activity->description, 100) }}</p>
                        <p class="text-muted">
                            <i class="far fa-calendar-alt"></i> {{ $activity->date->format('d/m/Y') }}
                            <br>
                            <i class="fas fa-map-marker-alt"></i> {{ $activity->location }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-primary">Voir détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection