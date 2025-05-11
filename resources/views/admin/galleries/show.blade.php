<!-- resources/views/admin/galleries/show.blade.php -->
@extends('layouts.admin')

@section('admin-title', $gallery->title)

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold">{{ $gallery->title }}</h2>
            <div class="flex items-center mt-2">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ $gallery->type_label }}
                </span>
                @if($gallery->related)
                <span class="ml-2 text-sm text-gray-600">
                    Associé à: {{ $gallery->related->title ?? $gallery->related->name }}
                </span>
                @endif
            </div>
            @if($gallery->description)
            <p class="mt-2 text-gray-600">{{ $gallery->description }}</p>
            @endif
        </div>
        <div>
            <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette galerie ? Tous les médias associés seront également supprimés.')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Formulaire d'upload -->
    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium mb-3">Ajouter des médias</h3>
        <form action="{{ route('admin.galleries.upload', $gallery) }}" method="POST" enctype="multipart/form-data" class="flex items-center">
            @csrf
            <input type="file" name="files[]" multiple
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>
        <p class="mt-2 text-sm text-gray-500">Formats acceptés: JPG, PNG, GIF, MP4 (max 5MB par fichier)</p>
    </div>

    <!-- Galerie des médias -->
    @if($gallery->items->isEmpty())
    <div class="bg-gray-50 p-8 text-center rounded-lg">
        <p class="text-gray-500">Aucun média dans cette galerie</p>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($gallery->items as $media)
        <div class="relative group">
            @if($media->file_type === 'image')
                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->caption }}" 
                    class="w-full h-40 object-cover rounded-lg shadow-sm">
            @else
                <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            @endif
            
            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <form action="{{ route('admin.media.destroy', $media) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white hover:text-red-300 p-2" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.galleries.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
    </div>
</div>
@endsection