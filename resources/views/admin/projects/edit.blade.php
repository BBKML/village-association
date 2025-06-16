@extends('layouts.admin')

@section('admin-title', 'Modifier le Projet')

@section('admin-content')
<div class="bg-white p-6 rounded shadow-md w-full max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Modifier le projet : {{ $project->title }}</h2>

    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Titre -->
        <div>
            <label for="title" class="block text-gray-700 font-medium">Titre *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}"
                   class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('title') border-red-500 @enderror" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-gray-700 font-medium">Description *</label>
            <textarea id="description" name="description" rows="5"
                      class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror" required>{{ old('description', $project->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block text-gray-700 font-medium">Date de début *</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}"
                       class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('start_date') border-red-500 @enderror" required>
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 font-medium">Date de fin</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}"
                       class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Statut -->
        <div>
            <label for="status" class="block text-gray-700 font-medium">Statut *</label>
            <select id="status" name="status"
                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('status') border-red-500 @enderror" required>
                <option value="planned" {{ old('status', $project->status) == 'planned' ? 'selected' : '' }}>Planifié</option>
                <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                <option value="postponed" {{ old('status', $project->status) == 'postponed' ? 'selected' : '' }}>Reporté</option>
                <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image principale -->
        <div>
            <label class="block text-gray-700 font-medium">Image principale</label>
            @if($project->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="Image actuelle" class="rounded shadow-md max-h-40">
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remove_image" id="remove_image" class="mr-2">
                            Supprimer l'image actuelle
                        </label>
                    </div>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 @error('image') border-red-500 @enderror">
            <small class="text-gray-500 text-sm">Format: JPEG, PNG, JPG, GIF (max: 2MB)</small>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Bénévoles et dons -->
        <div class="flex space-x-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="needs_volunteers" id="needs_volunteers" class="mr-2"
                       {{ old('needs_volunteers', $project->needs_volunteers) ? 'checked' : '' }}>
                Besoin de bénévoles
            </label>
            <label class="inline-flex items-center">
                <input type="checkbox" name="needs_donations" id="needs_donations" class="mr-2"
                       {{ old('needs_donations', $project->needs_donations) ? 'checked' : '' }}>
                Besoin de dons
            </label>
        </div>

        <!-- Galerie d'images -->
        <div>
            <label class="block text-gray-700 font-medium">Galerie d'images</label>
            @if($project->gallery && $project->gallery->items->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-4">
                    @foreach($project->gallery->items as $item)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $item->file_path) }}" class="rounded shadow-md w-full h-32 object-cover" alt="Image galerie">
                            <button type="button" onclick="if(confirm('Supprimer cette image ?')) document.getElementById('delete-media-{{ $item->id }}').submit();"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow hover:bg-red-700">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                            <form id="delete-media-{{ $item->id }}" method="POST" action="{{ route('admin.media.destroy', $item->id) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic text-sm mt-2">Aucune image dans la galerie</p>
            @endif
            <input type="file" name="gallery_images[]" id="gallery_images" multiple accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 @error('gallery_images.*') border-red-500 @enderror">
            <small class="text-gray-500 text-sm">Vous pouvez sélectionner plusieurs images (max: 2MB par image)</small>
            @error('gallery_images.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Annuler
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection