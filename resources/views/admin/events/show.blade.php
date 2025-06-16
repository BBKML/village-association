@extends('layouts.admin')

@section('title', 'Détails de l\'Événement')

@section("admin-content")

<div class="bg-white shadow-md rounded p-6 mb-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Détails de l'événement : {{ $event->title }}</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.events.edit', $event) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Image -->
        <div class="mb-4">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement" class="w-full h-64 object-cover rounded-lg shadow-md">
            @else
                <div class="alert alert-warning text-yellow-600 font-medium p-4 rounded-lg">
                    Aucune image principale disponible
                </div>
            @endif
        </div>

        <!-- Détails -->
        <div>
            <h3 class="text-xl font-semibold mb-4">{{ $event->title }}</h3>

            <!-- Dates -->
            <div class="mb-4">
                <h5 class="text-lg font-medium text-gray-700">Dates</h5>
                <p class="text-sm">
                    Du <strong>{{ $event->start_date->format('d/m/Y H:i') }}</strong><br>
                    au <strong>{{ $event->end_date->format('d/m/Y H:i') }}</strong>
                </p>
            </div>

            <!-- Lieu -->
            <div class="mb-4">
                <h5 class="text-lg font-medium text-gray-700">Lieu</h5>
                <p class="text-sm">{{ $event->location }}</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h5 class="text-lg font-medium text-gray-700">Description</h5>
                <p class="text-sm">{{ $event->description }}</p>
            </div>
        </div>
    </div>

    <!-- Galerie -->
    @if($event->gallery && $event->gallery->items->count() > 0)
        <hr class="my-6">
        <h5 class="text-lg font-medium text-gray-700 mb-4">Galerie d'images</h5>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($event->gallery->items as $item)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="Image galerie" class="w-full h-40 object-cover rounded-lg shadow-md">
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Footer -->
<div class="bg-gray-100 p-4 mt-6 rounded-lg shadow-sm">
    <small class="text-gray-600">Créé le : {{ $event->created_at->format('d/m/Y H:i') }}</small><br>
    <small class="text-gray-600">Dernière modification : {{ $event->updated_at->format('d/m/Y H:i') }}</small>
</div>

@endsection
