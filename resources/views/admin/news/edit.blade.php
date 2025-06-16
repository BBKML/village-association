<!-- resources/views/admin/news/edit.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Éditer une actualité')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Éditer l'actualité</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Contenu -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu *</label>
                <textarea name="content" id="content" rows="10" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('content', $news->content) }}</textarea>
            </div>

            <!-- Date de publication -->
            <div>
                <label for="published_at" class="block text-sm font-medium text-gray-700">Date de publication *</label>
                <input type="date" name="published_at" id="published_at" 
                    value="{{ old('published_at', $news->published_at->format('Y-m-d')) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                @if ($news->image)
                    <div class="mt-2 flex items-center">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="Image actuelle" class="h-16 rounded">
                        <label class="ml-4 flex items-center">
                            <input type="checkbox" name="remove_image" value="1"
                                {{ old('remove_image') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Supprimer l'image</span>
                        </label>
                    </div>
                @endif
                <input type="file" name="image" id="image"
                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver l'image actuelle</p>
            </div>

            <!-- Statut -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2">Publié</span>
                </label>
            </div>

            <!-- Mise en avant -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2">Mettre en avant</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.news.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 mr-3">
                Annuler
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
