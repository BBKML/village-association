@extends('layouts.admin')

@section('title', 'Créer un Événement')

@section('admin-content')
<div class="bg-white shadow-md rounded p-6">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Créer un nouvel événement</h2>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Titre -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full px-4 py-2 border rounded-lg @error('title') border-red-500 @enderror" required>
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-4 py-2 border rounded-lg @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Date de début *</label>
                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('start_date') border-red-500 @enderror" required>
                @error('start_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Date de fin *</label>
                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('end_date') border-red-500 @enderror" required>
                @error('end_date')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Lieu -->
        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lieu *</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}"
                class="w-full px-4 py-2 border rounded-lg @error('location') border-red-500 @enderror" required>
            @error('location')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image principale -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image principale *</label>
            <input type="file" name="image" id="image"
                class="w-full px-4 py-2 border rounded-lg @error('image') border-red-500 @enderror" required>
            <small class="text-gray-500 text-sm">Formats autorisés : JPEG, PNG, JPG, GIF (max. 2MB)</small>
            @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Galerie -->
        <div class="mb-6">
            <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-1">Images de la galerie</label>
            <input type="file" name="gallery_images[]" id="gallery_images" multiple
                class="w-full px-4 py-2 border rounded-lg @error('gallery_images.*') border-red-500 @enderror">
            <small class="text-gray-500 text-sm">Vous pouvez sélectionner plusieurs images (max. 2MB/image)</small>
            @error('gallery_images.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex items-center space-x-4">
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Créer l'événement
            </button>
            <a href="{{ route('admin.events.index') }}" class="px-5 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
