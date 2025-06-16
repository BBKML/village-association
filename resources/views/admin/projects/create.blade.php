@extends('layouts.admin')

@section('admin-title', 'Créer un Projet')

@section("admin-content")
<div class="bg-white shadow-md rounded p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Créer un nouveau projet</h2>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Titre -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
            <textarea id="description" name="description" rows="5" required
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début *</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('start_date') border-red-500 @enderror">
                @error('start_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('end_date') border-red-500 @enderror">
                @error('end_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Statut -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
            <select id="status" name="status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planifié</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                <option value="postponed" {{ old('status') == 'postponed' ? 'selected' : '' }}>Reporté</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
            </select>
            @error('status')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image principale -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image principale *</label>
            <input type="file" id="image" name="image" required accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 @error('image') border-red-500 @enderror">
            <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF (max: 2MB)</p>
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Besoins -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex items-center">
                <input type="checkbox" id="needs_volunteers" name="needs_volunteers" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ old('needs_volunteers') ? 'checked' : '' }}>
                <label for="needs_volunteers" class="ml-2 block text-sm text-gray-700">Besoin de bénévoles</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="needs_donations" name="needs_donations" class="h-4 w-4 text-green-600 border-gray-300 rounded" {{ old('needs_donations') ? 'checked' : '' }}>
                <label for="needs_donations" class="ml-2 block text-sm text-gray-700">Besoin de dons</label>
            </div>
        </div>

        <!-- Galerie -->
        <div>
            <label for="gallery_images" class="block text-sm font-medium text-gray-700">Images de la galerie</label>
            <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*"
                   class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 @error('gallery_images.*') border-red-500 @enderror">
            <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images (max: 2MB par image)</p>
            @error('gallery_images.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex justify-start gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Créer le projet
            </button>
            <a href="{{ route('admin.projects.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection