@extends('layouts.app')

@section('title', 'Projets - ' . ($association->name ?? 'Association'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Nos projets</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($projects as $project)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($project->image)
            <img src="{{ asset('storage/'.$project->image) }}" 
                 alt="{{ $project->title }}"
                 class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <h3 class="text-xl font-bold">{{ $project->title }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $project->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                           ($project->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $project->status_label }}
                    </span>
                </div>
                <div class="flex items-center text-sm text-gray-500 mt-2">
                    <span>{{ $project->start_date->format('d/m/Y') }}</span>
                    @if($project->end_date)
                    <span class="mx-2">-</span>
                    <span>{{ $project->end_date->format('d/m/Y') }}</span>
                    @endif
                </div>
                <p class="mt-4 text-gray-700">{{ $project->description }}</p>
                
                @if($project->needs_volunteers)
                <div class="mt-4">
                    <a href="{{ route('projects.volunteer', $project) }}" 
                       class="inline-block bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm font-bold">
                        Devenir bénévole
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $projects->links() }}
    </div>
</div>
@endsection