@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Nos Projets</h1>
    
    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-img-top-container">
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}">
                        @if($project->status === 'en_cours')
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">En cours</span>
                        @elseif($project->status === 'termine')
                            <span class="badge bg-success position-absolute top-0 start-0 m-2">Terminé</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                        <p class="text-muted">
                            <i class="far fa-calendar-alt"></i> 
                            {{ $project->start_date->format('d/m/Y') }} - 
                            {{ $project->end_date ? $project->end_date->format('d/m/Y') : 'À définir' }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">Voir le projet</a>
                        @if($project->needs_volunteers)
                            <span class="badge bg-info text-dark float-end">Recherche bénévoles</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection