@extends('layouts.app')

@section('title', 'Nos Projets - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Nos <span class="text-yellow-300">Projets</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Découvrez nos initiatives qui façonnent l'avenir de notre communauté
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#projects" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Explorer les projets <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16" id="projects">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Nos Projets</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Découvrez nos projets en cours et à venir, et participez à la construction de notre communauté.
        </p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
            <h3 class="text-3xl font-bold text-blue-600 mb-2">{{ $projectsCount }}</h3>
            <p class="text-gray-600">Projets au total</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
            <h3 class="text-3xl font-bold text-yellow-500 mb-2">{{ $ongoingCount }}</h3>
            <p class="text-gray-600">Projets en cours</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
            <h3 class="text-3xl font-bold text-green-500 mb-2">{{ $completedCount }}</h3>
            <p class="text-gray-600">Projets terminés</p>
        </div>
    </div>

    @if($projects->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Aucun projet n'est disponible pour le moment.</p>
        </div>
    @else
        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group">
                <!-- Project Image -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $project->image) }}" 
                         alt="{{ $project->title }}" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    
                    <!-- Status Badge -->
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold shadow-md
                        {{ $project->status === 'in_progress' ? 'bg-yellow-400 text-yellow-900' :
                           ($project->status === 'completed' ? 'bg-green-500 text-white' :
                           ($project->status === 'planned' ? 'bg-blue-400 text-white' :
                           ($project->status === 'postponed' ? 'bg-orange-400 text-white' :
                           'bg-red-400 text-white'))) }}">
                        <i class="fas {{ $project->status_icon }} mr-1"></i>
                        {{ $project->status_label }}
                    </span>
                </div>
                
                <!-- Project Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $project->title }}</h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <span>{{ $project->start_date->format('d/m/Y') }}</span>
                        @if($project->end_date)
                        <span class="mx-2">-</span>
                        <span>{{ $project->end_date->format('d/m/Y') }}</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($project->description, 150) }}</p>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($project->needs_volunteers)
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                            <i class="fas fa-hands-helping mr-1"></i> Bénévoles
                        </span>
                        @endif
                        @if($project->needs_donations)
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            <i class="fas fa-donate mr-1"></i> Dons
                        </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('projects.show', $project->id) }}" 
                       class="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                        En savoir plus
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $projects->links() }}
        </div>
    @endif
</div>

<!-- Stats Section -->
<section class="bg-gradient-to-r from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Nos projets en chiffres</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-12"></div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $projectsCount }}</div>
                <div class="text-gray-600">Projets réalisés</div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $ongoingCount }}</div>
                <div class="text-gray-600">Projets en cours</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">0</div>
                <div class="text-gray-600">Projets en cours</div>
            </div>
                        <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">0</div>
                <div class="text-gray-600">Projets en cours</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">Vous souhaitez proposer un projet ?</h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
            Nous sommes toujours ouverts aux nouvelles idées et collaborations pour faire grandir notre communauté.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact.create') }}" class="btn-primary bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100">
                Proposer un projet <i class="fas fa-lightbulb ml-2"></i>
            </a>
            <a href="{{ route('contact.create') }}" class="btn-accent bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500">
                Devenir bénévole <i class="fas fa-hands-helping ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection