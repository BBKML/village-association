@extends('layouts.app')

@section('title', 'Accueil - ' . ($association->name ?? 'Association du Village'))

@section('content')
    <!-- Hero Section -->
    <section class="bg-blue-700 text-white py-12 mb-8 rounded-lg">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Bienvenue à {{ $association->name ?? 'notre association' }}</h1>
            <p class="text-xl mb-6">{{ $association->description ?? 'Description courte de votre association' }}</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('association.about') }}"
                   class="bg-white text-blue-700 px-6 py-2 rounded font-bold hover:bg-gray-100">
                    Découvrir l'association
                </a>
                <a href="{{ route('contact.create') }}"
                   class="bg-blue-800 text-white px-6 py-2 rounded font-bold hover:bg-blue-900">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Actualités -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 pb-2 border-b">Dernières actualités</h2>

        @if($latestNews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestNews as $news)
                    <div class="bg-white rounded-lg shadow p-6">
                        @if($news->image)
                            <img src="{{ asset('storage/'.$news->image) }}"
                                 alt="{{ $news->title }}"
                                 class="w-full h-48 object-cover mb-4 rounded">
                        @endif
                        <h3 class="text-xl font-bold mb-2">{{ $news->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ $news->published_at->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-gray-700 mb-4">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                        <a href="{{ route('news.show', $news) }}" class="text-blue-600 hover:underline">
                            Lire la suite
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('news.index') }}" class="text-blue-600 font-bold hover:underline">
                    Voir toutes les actualités →
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500">Aucune actualité disponible pour le moment</p>
            </div>
        @endif
    </section>

    <!-- Événements -->
    <section class="mb-12 bg-gray-100 p-6 rounded-lg">
        <h2 class="text-2xl font-bold mb-6 pb-2 border-b">Événements à venir</h2>

        @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $event)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ $event->start_date->translatedFormat('d F Y \à H\hi') }}
                        </p>
                        @if($event->location)
                            <p class="text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i> {{ $event->location }}
                            </p>
                        @endif
                        <p class="text-gray-700 mb-4">{{ Str::limit($event->description, 100) }}</p>
                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:underline">
                            Plus d'informations
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('events.calendar') }}" class="text-blue-600 font-bold hover:underline">
                    Voir le calendrier complet →
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500">Aucun événement à venir pour le moment</p>
            </div>
        @endif
    </section>

    <!-- Projets -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 pb-2 border-b">Projets en cours</h2>

        @if($ongoingProjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($ongoingProjects as $project)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $project->title }}</h3>
                        <span class="inline-block px-3 py-1 rounded-full text-xs
                            {{ $project->status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                               ($project->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $project->status_label }}
                        </span>
                        <p class="text-gray-700 my-4">{{ Str::limit($project->description, 120) }}</p>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">
                                En savoir plus
                            </a>
                            @if($project->needs_volunteers)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                                    Bénévoles recherchés
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('projects.index') }}" class="text-blue-600 font-bold hover:underline">
                    Voir tous les projets →
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-500">Aucun projet en cours pour le moment</p>
            </div>
        @endif
    </section>
@endsection
