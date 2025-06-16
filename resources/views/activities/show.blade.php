@extends('layouts.app')

@section('title', $activity->title . ' - ' . ($association->name ?? 'Association'))

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête de l'activité -->
        <div class="mb-8">
            <a href="{{ route('activities.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux activités
            </a>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $activity->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-4 text-gray-600">
                <div class="flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                    <span>{{ $activity->date->translatedFormat('d F Y') }}</span>
                </div>
                
                @if($activity->time)
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2 text-blue-500"></i>
                        <span>{{ $activity->time }}</span>
                    </div>
                @endif
                
                @if($activity->location)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                        <span>{{ $activity->location }}</span>
                    </div>
                @endif
                
                @if($activity->category)
                    <div class="flex items-center">
                        <i class="fas fa-tag mr-2 text-blue-500"></i>
                        <span>{{ $activity->category }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Image principale -->
        @if($activity->image)
            <div class="relative h-96 rounded-2xl overflow-hidden mb-8">
                <img src="{{ asset('storage/' . $activity->image) }}"
                     alt="{{ $activity->title }}"
                     class="w-full h-full object-cover">
            </div>
        @endif
        
        <!-- Description -->
        <div class="prose prose-lg max-w-none mb-12">
            {!! nl2br(e($activity->description)) !!}
        </div>
        
        <!-- Informations supplémentaires -->
        @if($activity->available_spots !== null)
            <div class="bg-blue-50 rounded-xl p-6 mb-12">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Places disponibles</h3>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-800">{{ $activity->available_spots }}</p>
                        <p class="text-blue-600">places restantes</p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Galerie d'images -->
        @if($activity->gallery && $activity->gallery->items->isNotEmpty())
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Galerie photos</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($activity->gallery->items as $item)
                        @if($item->file_type === 'image')
                            <div class="relative aspect-square rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $item->file_path) }}"
                                     alt="{{ $item->caption }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Activités connexes -->
        @if($relatedActivities->isNotEmpty())
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Autres activités</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedActivities as $relatedActivity)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            @if($relatedActivity->image)
                                <img src="{{ asset('storage/' . $relatedActivity->image) }}"
                                     alt="{{ $relatedActivity->title }}"
                                     class="w-full h-48 object-cover">
                            @endif
                            
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">{{ $relatedActivity->title }}</h4>
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    <span>{{ $relatedActivity->date->translatedFormat('d M Y') }}</span>
                                </div>
                                <a href="{{ route('activities.show', $relatedActivity) }}"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    Voir détails <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
