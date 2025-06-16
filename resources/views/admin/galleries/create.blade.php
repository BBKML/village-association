@extends('layouts.admin')

@section('title', 'Créer une nouvelle galerie')

@section('admin-content')
<div class="bg-white shadow-md rounded p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-semibold text-blue-600 mb-6 flex items-center">
        <i class="fas fa-plus mr-2"></i>Créer une nouvelle galerie
    </h2>

    <form action="{{ route('admin.galleries.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
            <select name="type" id="type" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="activity">Activité</option>
                <option value="project">Projet</option>
                <option value="event">Événement</option>
                <option value="other">Autre</option>
            </select>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 transition">
                <i class="fas fa-check mr-2"></i>Créer la galerie
            </button>
        </div>
    </form>
</div>
@endsection
