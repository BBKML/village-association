<!-- resources/views/admin/galleries/create.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Créer une galerie')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Nouvelle galerie média</h2>
    
    <form action="{{ route('admin.galleries.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                <input type="text" name="title" id="title" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Sélectionnez un type</option>
                    <option value="activity">Activité</option>
                    <option value="project">Projet</option>
                    <option value="event">Événement</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <!-- Élément associé -->
            <div>
                <label for="related_id" class="block text-sm font-medium text-gray-700">Associer à (optionnel)</label>
                <input type="number" name="related_id" id="related_id" min="1"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="ID de l'élément associé">
                <p class="mt-1 text-sm text-gray-500">Laissez vide si non applicable</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.galleries.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 mr-3">
                Annuler
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Créer la galerie
            </button>
        </div>
    </form>
</div>
@endsection