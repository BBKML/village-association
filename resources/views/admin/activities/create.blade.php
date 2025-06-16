@extends('layouts.admin')

@section('title', 'Ajouter une Activité')

@section('admin-content')
<div class="bg-white p-6 rounded shadow-md w-full max-w-3xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6">Ajouter une Activité</h2>

    <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Titre -->
        <div>
            <label for="title" class="block text-gray-700 font-medium">Titre *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('title') border-red-500 @enderror" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-gray-700 font-medium">Description *</label>
            <textarea id="description" name="description" rows="4"
                      class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image principale -->
        <div>
            <label for="image" class="block text-gray-700 font-medium">Image principale</label>
            <input type="file" id="image" name="image" accept="image/*"
                   class="mt-1 w-full @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date et heure -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="date" class="block text-gray-700 font-medium">Date *</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}"
                       class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('date') border-red-500 @enderror" required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="time" class="block text-gray-700 font-medium">Heure</label>
                <input type="time" id="time" name="time" value="{{ old('time') }}"
                       class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('time') border-red-500 @enderror">
                @error('time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Lieu -->
        <div>
            <label for="location" class="block text-gray-700 font-medium">Lieu *</label>
            <input type="text" id="location" name="location" value="{{ old('location') }}"
                   class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('location') border-red-500 @enderror" required>
            @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Catégorie -->
        <div>
            <label for="category" class="block text-gray-700 font-medium">Catégorie</label>
            <select id="category" name="category"
                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('category') border-red-500 @enderror">
                <option value="">Sélectionner une catégorie</option>
                <option value="Culturelle" {{ old('category') == 'Culturelle' ? 'selected' : '' }}>Culturelle</option>
                <option value="Sportive" {{ old('category') == 'Sportive' ? 'selected' : '' }}>Sportive</option>
                <option value="Éducative" {{ old('category') == 'Éducative' ? 'selected' : '' }}>Éducative</option>
                <option value="Sociale" {{ old('category') == 'Sociale' ? 'selected' : '' }}>Sociale</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Places disponibles -->
        <div>
            <label for="available_spots" class="block text-gray-700 font-medium">Places disponibles</label>
            <input type="number" id="available_spots" name="available_spots" value="{{ old('available_spots') }}" min="0"
                   class="mt-1 w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-blue-200 @error('available_spots') border-red-500 @enderror">
            @error('available_spots')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mettre en avant -->
        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200">
                <span class="ml-2 text-gray-700">Mettre en avant</span>
            </label>
        </div>

        <!-- Galerie d'images -->
        <div>
            <label for="gallery_images" class="block text-gray-700 font-medium">Galerie d'images</label>
            <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple
                   class="mt-1 w-full @error('gallery_images') border-red-500 @enderror">
            <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images</p>
            @error('gallery_images')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.activities.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Annuler
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Créer l'activité
            </button>
        </div>
    </form>
</div>
@endsection
