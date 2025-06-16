@extends('layouts.app')

@section('title', 'Accueil - ' . ($association->name ?? 'Association du Village'))

@section('hero-section')
    <!-- Hero Section -->
    <section class="hero-section text-white py-24 md:py-32">
        <div class="container mx-auto px-4 text-center hero-content">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
                Bienvenue à <span class="text-yellow-300">{{ $association->name ?? 'notre association' }}</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
                {{ $association->description ?? 'Description courte de votre association' }}
            </p>
            <div class="flex flex-wrap justify-center gap-6 animate-fadeInUp" style="animation-delay: 0.5s">
                <a href="{{ route('association.about') }}"
                   class="btn-primary px-8 py-4 rounded-full font-bold transition duration-300">
                    Découvrir l'association <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="{{ route('contact.create') }}"
                   class="btn-accent px-8 py-4 rounded-full font-bold transition duration-300">
                    Nous contacter <i class="fas fa-paper-plane ml-2"></i>
                </a>
            </div>
            
            <!-- Statistiques de l'association -->
            <div class="mt-16 flex flex-wrap justify-center gap-8 animate-fadeInUp" style="animation-delay: 0.7s">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm p-4 rounded-xl border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-yellow-300">+150</div>
                    <div class="text-sm uppercase tracking-wider">Membres</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-sm p-4 rounded-xl border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-yellow-300">+20</div>
                    <div class="text-sm uppercase tracking-wider">Événements/an</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-sm p-4 rounded-xl border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-yellow-300">+10</div>
                    <div class="text-sm uppercase tracking-wider">Projets</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <!-- Actualités -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center section-title">Dernières actualités</h2>

            @if($latestNews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($latestNews as $news)
                        <div class="card hover-scale">
                            @if($news->image)
                                <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="card-image">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">{{ $news->title }}</h3>
                                <div class="card-date">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ $news->published_at->translatedFormat('d F Y') }}
                                </div>
                                <p class="card-text">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                <a href="{{ route('news.show', $news) }}" class="card-link">
                                    Lire la suite <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('news.index') }}" class="btn-primary px-6 py-3 rounded-full inline-flex items-center">
                        Voir toutes les actualités <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucune actualité disponible pour le moment</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Événements à venir -->
    <section class="py-16 bg-gradient-to-r from-blue-50 to-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center section-title">Événements à venir</h2>

            @if($upcomingEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($upcomingEvents as $event)
                        <div class="card hover-scale">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="card-image">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">{{ $event->title }}</h3>
                                <div class="card-date">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ $event->start_date->format('d/m/Y H:i') }}
                                    @if($event->end_date)
                                        - {{ $event->end_date->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                                <p class="card-text">{{ Str::limit($event->description, 150) }}</p>
                                <a href="{{ route('events.show', $event) }}" class="card-link mt-4">
                                    Voir détails <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('events.calendar') }}" class="btn-primary px-6 py-3 rounded-full inline-flex items-center">
                        Voir le calendrier complet <i class="fas fa-calendar-alt ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun événement à venir pour le moment</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Projets en cours -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center section-title">Nos projets</h2>

            @if($ongoingProjects->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @foreach($ongoingProjects as $project)
                        <div class="card hover-scale">
                            @if($project->image)
                                <img src="{{ asset('storage/'.$project->image) }}"
                                     alt="{{ $project->title }}"
                                     class="card-image">
                            @endif
                            <div class="card-body">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="card-title">{{ $project->title }}</h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        {{ $project->status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                                           ($project->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $project->status_label }}
                                    </span>
                                </div>
                                <div class="card-date">
                                    <i class="far fa-calendar mr-2"></i>
                                    <span>{{ $project->start_date->format('d/m/Y') }}</span>
                                    @if($project->end_date)
                                    <span class="mx-2">-</span>
                                    <span>{{ $project->end_date->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                <p class="card-text">{{ $project->description }}</p>

                                <div class="flex justify-between items-center mt-6">
                                    <a href="{{ route('projects.show', $project->id) }}" class="card-link">
                                        En savoir plus
                                    </a>
                                    @if($project->needs_volunteers)
                                    <a href="{{ route('projects.volunteer', $project) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition duration-300">
                                        Devenir bénévole
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('projects.index') }}" class="btn-primary px-6 py-3 rounded-full inline-flex items-center">
                        Voir tous nos projets <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <i class="fas fa-project-diagram text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun projet en cours pour le moment</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Membres du bureau -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-12 text-center section-title">Notre équipe</h2>

            @if($boardMembers->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($boardMembers as $member)
                        <div class="card hover-scale text-center">
                            @if($member->image)
                                <img src="{{ asset('storage/'.$member->image) }}"
                                     alt="{{ $member->full_name }}"
                                     class="card-image">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-6xl text-gray-400"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h3>
                                <p class="text-blue-600 font-medium">{{ $member->role }}</p>
                                <p class="text-gray-500 text-sm mt-2">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Membre depuis {{ $member->joined_date->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <a href="{{ route('association.members') }}" class="btn-primary px-6 py-3 rounded-full inline-flex items-center">
                        Voir tous les membres <i class="fas fa-users ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-user-friends text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun membre à afficher pour le moment</p>
                </div>
            @endif
        </div>
    </section>

   <!-- Galerie photos -->
<!-- Galerie photos simplifiée : seulement images et vidéos -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">

        @if($galleries->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galleries as $gallery)
                    @foreach($gallery->items as $item)
                        <div class="card shadow-sm rounded overflow-hidden">
                            @if($item->file_type === 'image')
                                <img src="{{ asset('storage/' . $item->file_path) }}" 
                                     class="w-full h-48 object-cover" 
                                     alt="{{ $item->caption ?? '' }}">
                            @elseif($item->file_type === 'video')
                                <video controls class="w-full h-48 object-cover">
                                    <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <i class="fas fa-camera text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucune galerie disponible pour le moment</p>
            </div>
        @endif
    </div>
</section>

@endsection