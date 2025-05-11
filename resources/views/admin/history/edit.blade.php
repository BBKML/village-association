<!-- resources/views/admin/histories/edit.blade.php -->
@extends('layouts.admin')

@section('admin-title', "Éditer l'historique du village")

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Historique du village</h2>
    
    <form action="{{ route('admin.histories.update', $history) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $history->title) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                @if($history->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $history->image) }}" alt="Image actuelle" class="h-48 rounded-lg">
                    <label class="mt-2 inline-flex items-center">
                        <input type="checkbox" name="remove_image" value="1" class="text-red-600">
                        <span class="ml-2 text-sm text-gray-600">Supprimer l'image</span>
                    </label>
                </div>
                @endif
                <input type="file" name="image" id="image"
                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Contenu -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu *</label>
                <textarea name="content" id="content" rows="10" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('content', $history->content) }}</textarea>
            </div>

            <!-- Fondateur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="founder_name" class="block text-sm font-medium text-gray-700">Nom du fondateur</label>
                    <input type="text" name="founder_name" id="founder_name" value="{{ old('founder_name', $history->founder_name) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="founder_description" class="block text-sm font-medium text-gray-700">Description du fondateur</label>
                    <textarea name="founder_description" id="founder_description" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('founder_description', $history->founder_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection