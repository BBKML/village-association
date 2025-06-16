@extends('layouts.admin')

@section('title', 'Modifier la Galerie')

@section('admin-content')
<div class="bg-white shadow-lg rounded-xl p-8 max-w-3xl mx-auto mt-6">
    <h2 class="text-3xl font-bold text-blue-700 mb-8 flex items-center">
        <i class="fas fa-edit mr-2"></i> Modifier la Galerie
    </h2>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Titre -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $gallery->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
            <select id="type" name="type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror" required>
                <option value="activity" {{ old('type', $gallery->type) === 'activity' ? 'selected' : '' }}>Activité</option>
                <option value="project" {{ old('type', $gallery->type) === 'project' ? 'selected' : '' }}>Projet</option>
                <option value="event" {{ old('type', $gallery->type) === 'event' ? 'selected' : '' }}>Événement</option>
                <option value="other" {{ old('type', $gallery->type) === 'other' ? 'selected' : '' }}>Autre</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('admin.galleries.index') }}"
               class="inline-flex items-center px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i> Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
