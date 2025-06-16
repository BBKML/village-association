@extends('layouts.admin')

@section('admin-title', "Détails de l'Association")

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Détails de l'association : {{ $association->name }}</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.associations.edit', $association) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('admin.associations.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            @if($association->main_image)
                <img src="{{ asset('storage/' . $association->main_image) }}" alt="Image de l'association" class="rounded-lg shadow w-full object-cover">
            @else
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-700 p-4 rounded">
                    Aucune image disponible
                </div>
            @endif
        </div>

        <div class="md:col-span-2">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Nom de l'association</h3>
                <p class="text-gray-800">{{ $association->name }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Description</h3>
                <p class="text-gray-800">{{ $association->description }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Objectifs</h3>
                <p class="text-gray-800">{{ $association->objectives }}</p>
            </div>

            <div class="text-sm text-gray-500">
                <p>Créée le : {{ $association->created_at->format('d/m/Y H:i') }}</p>
                <p>Dernière modification : {{ $association->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
