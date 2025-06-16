@extends('layouts.admin')

@section('admin-title', isset($history->id) ? "Éditer l'historique" : "Créer un historique")

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        {{ isset($history->id) ? "Éditer l'historique" : "Créer un historique" }}
    </h2>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded mb-6">
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($history->id) ? route('admin.history.update', $history) : route('admin.history.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($history) && $history->exists)
            @method('PUT')
        @endif

        <div class="space-y-6">
            <!-- Titre -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                <input type="text" name="title" id="title" 
                value="{{ old('title', $history->title ?? '') }}" required>

               <textarea name="content" id="content" rows="10" required>{{ old('content', $history->content ?? '') }}</textarea>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <p class="text-sm text-gray-500 mb-2">Formats acceptés: JPG, PNG, GIF (max: 2MB)</p>

                @if(isset($history->image) && $history->image)
                    <div class="mt-2 space-y-2">
                        <img src="{{ asset('storage/' . $history->image) }}" alt="Image actuelle" class="h-48 rounded-lg shadow-sm">
                        <label class="inline-flex items-center text-sm text-gray-600">
                            <input type="checkbox" name="remove_image" value="1" class="text-red-600 border-gray-300 rounded">
                            <span class="ml-2">Supprimer l'image</span>
                        </label>
                    </div>
                @endif

                <input type="file" name="image" id="image"
                    class="mt-3 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Contenu -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu *</label>
                <textarea name="content" id="content" rows="10" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('content', $history->content ?? '') }}</textarea>
            </div>

            <!-- Fondateur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="founder_name" class="block text-sm font-medium text-gray-700">Nom du fondateur</label>
                    <input type="text" name="founder_name" id="founder_name" value="{{ old('founder_name', $history->founder_name ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>

                <div>
                    <label for="founder_description" class="block text-sm font-medium text-gray-700">Description du fondateur</label>
                    <textarea name="founder_description" id="founder_description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('founder_description', $history->founder_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.history.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50">
                Annuler
            </a>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                {{ isset($history->id) ? 'Enregistrer les modifications' : 'Créer l\'historique' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#content',
                height: 400,
                plugins: 'link image code table lists',
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
            });
        }
    });
</script>
@endpush
@endsection
