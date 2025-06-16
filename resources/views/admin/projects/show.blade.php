@extends('layouts.admin')

@section('title', 'Détails du Projet')

@section("admin-content")
<div class="bg-white p-6 rounded shadow-md w-full max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Détails du projet : {{ $project->title }}</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.projects.edit', $project) }}" class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Colonne gauche : Image et infos -->
        <div>
            @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" alt="Image du projet" class="rounded shadow mb-4 w-full h-auto object-cover max-h-64">
            @else
                <p class="text-gray-500 italic mb-4">Aucune image principale disponible.</p>
            @endif

            <div class="bg-gray-100 p-4 rounded shadow">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Statut</h4>
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded bg-{{ $project->status_class }}-200 text-{{ $project->status_class }}-800">
                    {{ $project->status_label }}
                </span>

                <h4 class="text-lg font-semibold text-gray-700 mt-4 mb-2">Dates</h4>
                <p class="text-gray-600">
                    Début : {{ $project->start_date->format('d/m/Y') }}<br>
                    Fin : {{ $project->end_date ? $project->end_date->format('d/m/Y') : 'Non définie' }}
                </p>

                <h4 class="text-lg font-semibold text-gray-700 mt-4 mb-2">Besoins</h4>
                <div class="space-x-2">
                    @if($project->needs_volunteers)
                        <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">Bénévoles</span>
                    @endif
                    @if($project->needs_donations)
                        <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded text-sm">Dons</span>
                    @endif
                    @if(!$project->needs_volunteers && !$project->needs_donations)
                        <span class="text-gray-500 italic text-sm">Aucun besoin spécifique</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne droite : Description & Galerie -->
        <div class="md:col-span-2">
            <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $project->title }}</h3>

            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Description</h4>
                <p class="text-gray-600">{{ $project->description }}</p>
            </div>

            @if($project->gallery && $project->gallery->items->count() > 0)
                <h4 class="text-lg font-semibold text-gray-700 mb-3">Galerie d'images</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($project->gallery->items as $item)
                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="Image galerie" class="rounded shadow-md object-cover h-32 w-full">
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Aucune image dans la galerie</p>
            @endif
        </div>
    </div>

    <div class="border-t mt-6 pt-4 text-sm text-gray-500">
        <p>Créé le : {{ $project->created_at->format('d/m/Y H:i') }}</p>
        <p>Dernière modification : {{ $project->updated_at->format('d/m/Y H:i') }}</p>
    </div>
</div>
@endsection