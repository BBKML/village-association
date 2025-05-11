<!-- resources/views/admin/services/show.blade.php -->
@extends('layouts.admin')

@section('admin-title', $service->name)

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold">{{ $service->name }}</h2>
            <div class="mt-2 flex items-center">
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $service->type }}
                </span>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.services.edit', $service) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Éditer
            </a>
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            @if($service->image)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="rounded-lg w-full max-w-md">
            </div>
            @endif

            <div class="prose max-w-none">
                <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                <p>{{ $service->description ?? 'Aucune description disponible' }}</p>

                <h3 class="text-lg font-semibold text-gray-900 mt-6">Coordonnées</h3>
                <ul class="list-disc pl-5">
                    <li><strong>Adresse :</strong> {{ $service->address }}</li>
                    <li><strong>Téléphone :</strong> {{ $service->phone }}</li>
                    @if($service->email)
                    <li><strong>Email :</strong> {{ $service->email }}</li>
                    @endif
                    @if($service->website)
                    <li><strong>Site web :</strong> <a href="{{ $service->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $service->website }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Date de création</p>
                        <p>{{ $service->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dernière modification</p>
                        <p>{{ $service->updated_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.services.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
    </div>
</div>
@endsection