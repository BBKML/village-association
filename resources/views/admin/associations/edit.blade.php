@extends('layouts.admin')

@section('admin-title', "Modifier l'association")

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Modifier l'association : {{ $association->name }}</h2>

    <form action="{{ route('admin.associations.update', $association) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'association *</label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $association->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500
                           @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                <textarea name="description" id="description" rows="3" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500
                           @error('description') border-red-500 @enderror">{{ old('description', $association->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Objectifs -->
            <div>
                <label for="objectives" class="block text-sm font-medium text-gray-700">Objectifs *</label>
                <textarea name="objectives" id="objectives" rows="3" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                           focus:outline-none focus:ring-blue-500 focus:border-blue-500
                           @error('objectives') border-red-500 @enderror">{{ old('objectives', $association->objectives) }}</textarea>
                @error('objectives')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image principale -->
            <div>
                <label for="main_image" class="block text-sm font-medium text-gray-700">Image principale</label>
                @if($association->main_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $association->main_image) }}" alt="Image actuelle" class="h-40 rounded-lg">
                    <label class="mt-2 inline-flex items-center">
                        <input type="checkbox" name="remove_image" id="remove_image" value="1" class="text-red-600">
                        <span class="ml-2 text-sm text-gray-600">Supprimer l'image actuelle</span>
                    </label>
                </div>
                @endif
                <input type="file" name="main_image" id="main_image" accept="image/*"
                    class="mt-2 block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-md file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100
                           @error('main_image') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Formats acceptés : JPEG, PNG, JPG, GIF (max : 2MB)</p>
                @error('main_image')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.associations.index') }}"
               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium
                      rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2
                      focus:ring-offset-2 focus:ring-gray-500">
                Annuler
            </a>
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium
                       rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2
                       focus:ring-offset-2 focus:ring-blue-500">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
