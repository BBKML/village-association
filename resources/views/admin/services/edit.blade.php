<!-- resources/views/admin/services/edit.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Éditer le service')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Éditer le service</h2>
    
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="commerçant" {{ $service->type === 'commerçant' ? 'selected' : '' }}>Commerçant</option>
                    <option value="artisan" {{ $service->type === 'artisan' ? 'selected' : '' }}>Artisan</option>
                    <option value="médical" {{ $service->type === 'médical' ? 'selected' : '' }}>Profession médicale</option>
                    <option value="école" {{ $service->type === 'école' ? 'selected' : '' }}>École</option>
                    <option value="autre" {{ $service->type === 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <!-- Image -->
            <div class="md:col-span-2">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                @if($service->image)
                <div class="mt-1 flex items-center">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="Image actuelle" class="h-16 w-16 rounded-md object-cover">
                    <label class="ml-4">
                        <input type="checkbox" name="remove_image" value="1" class="text-red-600">
                        <span class="ml-1 text-sm text-gray-600">Supprimer l'image</span>
                    </label>
                </div>
                @endif
                <input type="file" name="image" id="image"
                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $service->description) }}</textarea>
            </div>

            <!-- Adresse -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse *</label>
                <input type="text" name="address" id="address" value="{{ old('address', $service->address) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Téléphone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $service->phone) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $service->email) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Site web -->
            <div class="md:col-span-2">
                <label for="website" class="block text-sm font-medium text-gray-700">Site web</label>
                <input type="url" name="website" id="website" value="{{ old('website', $service->website) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.services.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 mr-3">
                Annuler
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection