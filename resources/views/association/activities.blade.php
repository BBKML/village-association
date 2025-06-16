@extends('layouts.app')

@section('title', 'Activités - ' . ($association->name ?? 'Association'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Nos activités récentes</h1>
        @if($activities->count() > 0)
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $activities->total() }} activité(s)
            </span>
        @endif
    </div>

    @if($activities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activities as $activity)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if($activity->image)
                        <img src="{{ asset('storage/'.$activity->image) }}" 
                             alt="{{ $activity->title }}"
                             class="w-full h-48 object-cover">
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-xl font-bold text-gray-800">{{ $activity->title }}</h2>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                {{ $activity->date->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        
                        @if($activity->location)
                            <div class="flex items-center text-gray-600 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $activity->location }}
                            </div>
                        @endif
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($activity->description, 120) }}</p>
                        
                        <a href="{{ route('activities.show', $activity) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                            Voir les détails
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-xl font-medium text-gray-500 mb-2">Aucune activité disponible</h3>
            <p class="text-gray-400 mb-4">Revenez plus tard pour découvrir nos prochaines activités.</p>
            <a href="{{ route('contact.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Proposer une activité
            </a>
        </div>
    @endif
</div>
@endsection