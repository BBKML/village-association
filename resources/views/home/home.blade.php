@extends('layouts.app')

@section('content')
<div class="container">
    <div class="hero-section mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4">Bienvenue sur notre site</h1>
                <p class="lead">Découvrez nos activités, projets et événements</p>
                <a href="{{ route('activities.index') }}" class="btn btn-primary btn-lg">Nos activités</a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/hero-image.jpg') }}" alt="Image d'accueil" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <section class="latest-news mb-5">
        <h2 class="section-title">Dernières actualités</h2>
        <div class="row">
            @foreach($latestNews as $news)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $news->title }}</h5>
                            <p class="card-text">{{ Str::limit($news->content, 100) }}</p>
                            <a href="{{ route('news.show', $news->id) }}" class="btn btn-outline-primary">Lire plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="upcoming-events mb-5">
        <h2 class="section-title">Événements à venir</h2>
        <div class="row">
            @foreach($upcomingEvents as $event)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">
                                <i class="far fa-calendar-alt"></i> {{ $event->start_date->format('d/m/Y H:i') }}
                                <br>
                                <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                            </p>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary">Détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
{{-- Section optionnelle pour les projets --}}
@isset($ongoingProjects)
<section class="ongoing-projects mb-5">
    <h2 class="section-title">Nos projets en cours</h2>
    <div class="row">
        @foreach($ongoingProjects as $project)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 120) }}</p>
                        <p class="text-muted">
                            <i class="far fa-calendar-alt"></i> 
                            Début: {{ $project->start_date->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">
                            Voir le projet
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endisset
@endsection