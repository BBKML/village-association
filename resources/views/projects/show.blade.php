@extends('layouts.app')

@section('title', $project->title . ' - ' . ($association->name ?? 'Projets'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-20 md:py-28 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-wrap gap-3 mb-4">
                
                @if($project->status === 'in_progress')
                    <span class="inline-flex items-center px-4 py-2 bg-yellow-400 text-yellow-900 rounded-full text-sm font-bold">
                        <i class="fas fa-spinner mr-2"></i> Projet en cours
                    </span>
                @elseif($project->status === 'completed')
                    <span class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-full text-sm font-bold">
                        <i class="fas fa-check-circle mr-2"></i> Projet terminé
                    </span>
                @endif
                
                @if($project->needs_volunteers)
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                        <i class="fas fa-hands-helping mr-2"></i> Recherche bénévoles
                    </span>
                @endif
                @if($project->needs_donations)
                    <span class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-bold">
                        <i class="fas fa-donate mr-2"></i> Recherche dons
                    </span>
                @endif
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $project->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-4 text-blue-100">
                <div class="flex items-center">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span>Début: {{ $project->start_date->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="far fa-clock mr-2"></i>
                    <span>Fin: {{ $project->end_date ? $project->end_date->translatedFormat('d F Y') : 'À définir' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16 max-w-4xl">
    <!-- Main Project Image -->
    <div class="rounded-xl shadow-xl overflow-hidden mb-12">
        <img src="{{ asset('storage/' . $project->image) }}" 
             alt="{{ $project->title }}" 
             class="w-full h-auto max-h-[500px] object-cover">
    </div>

    <!-- Project Content -->
    <article class="prose prose-lg max-w-none text-gray-700 mb-12">
        {!! $project->description !!}
    </article>

    <!-- Project Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <!-- Objectives -->
        <div class="bg-blue-50 rounded-xl p-6">
            <h3 class="text-xl font-bold text-blue-800 mb-4 flex items-center">
                <i class="fas fa-bullseye text-blue-600 mr-3"></i>
                Objectifs du projet
            </h3>
            <ul class="space-y-3">
                @foreach(explode("\n", $project->objectives) as $objective)
                    @if(trim($objective))
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                            <span>{{ $objective }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <!-- Impact -->
        <div class="bg-green-50 rounded-xl p-6">
            <h3 class="text-xl font-bold text-green-800 mb-4 flex items-center">
                <i class="fas fa-chart-line text-green-600 mr-3"></i>
                Impact attendu
            </h3>
            <ul class="space-y-3">
                @foreach(explode("\n", $project->impact) as $impactItem)
                    @if(trim($impactItem))
                        <li class="flex items-start">
                            <i class="fas fa-star text-yellow-500 mt-1 mr-2"></i>
                            <span>{{ $impactItem }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Gallery -->
    @if($project->gallery && $project->gallery->items->count() > 0)
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-images text-blue-600 mr-3"></i>
            Galerie du projet
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($project->gallery->items as $item)
            <a href="{{ asset('storage/' . $item->file_path) }}" 
               data-lightbox="project-gallery" 
               data-title="{{ $item->caption }}"
               class="group rounded-lg overflow-hidden block">
                <div class="relative aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $item->file_path) }}" 
                         alt="{{ $item->caption }}" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                </div>
                @if($item->caption)
                <p class="text-sm text-gray-600 mt-2 truncate">{{ $item->caption }}</p>
                @endif
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 md:mr-8">
                <h3 class="text-xl font-bold mb-2">Vous souhaitez soutenir ce projet ?</h3>
                <p class="text-blue-100">Chaque contribution fait la différence</p>
            </div>
            <div class="flex flex-wrap gap-4">
                @if($project->needs_volunteers)
                <a href="{{ route('projects.volunteer', $project) }}" 
                   class="btn-primary bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">
                   <i class="fas fa-hands-helping mr-2"></i> Devenir bénévole
                </a>
                @endif
                @if($project->needs_donations)
                <a href="{{ route('projects.donate', $project) }}" 
                   class="btn-accent bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg font-bold hover:bg-yellow-500">
                   <i class="fas fa-donate mr-2"></i> Faire un don
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Projects -->
    @if(isset($relatedProjects) && $relatedProjects->count() > 0)
    <div class="mt-16">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Découvrez nos autres projets</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedProjects as $related)
            <a href="{{ route('projects.show', $related) }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $related->image) }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        @if($related->status === 'en_cours')
                            <span class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">
                                En cours
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h4 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $related->title }}</h4>
                        
                        <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ Str::limit($related->description, 100) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<!-- Lightbox for gallery -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Image %1 sur %2"
    });
</script>
@endsection

@section('styles')
<style>
    .prose {
        line-height: 1.8;
    }
    .prose h2 {
        color: #1e3a8a;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
    }
    .prose h3 {
        color: #1e40af;
        font-weight: 600;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
    }
    .prose img {
        border-radius: 0.5rem;
        margin-top: 1.5em;
        margin-bottom: 1.5em;
    }
    .prose a {
        color: #2563eb;
        font-weight: 500;
        text-decoration: underline;
    }
    .prose a:hover {
        color: #1d4ed8;
    }
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        font-style: italic;
        color: #4b5563;
        margin: 1.5em 0;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection