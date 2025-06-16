<!-- resources/views/admin/history/show.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Détails de l\'historique')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">{{ $history->title }}</h2>
        <div>
            <a href="{{ route('admin.history.edit', $history) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
                Éditer
            </a>
            <a href="{{ route('admin.history.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Retour à la liste
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-6">
        <!-- Détails -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Contenu</h3>

                    <div class="prose max-w-none">
                        {!! $history->content !!}
                    </div>
                </div>
            </div>
            <div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Informations</h3>
                    <ul class="space-y-2">
                        <li><span class="font-semibold">Créé le:</span> {{ $history->created_at->format('d/m/Y H:i') }}</li>
                        <li><span class="font-semibold">Dernière mise à jour:</span> {{ $history->updated_at->format('d/m/Y H:i') }}</li>
                        <li><span class="font-semibold">Slug:</span> {{ $history->slug }}</li>
                        
                       @if(Route::has('history.show'))
                        <li><span class="font-semibold">URL publique:</span> 
                            <a href="{{ route('history.show', $history->slug) }}" 
                            class="text-blue-600 hover:underline" target="_blank">Voir la page</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Image -->
        @if($history->image)
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Image</h3>
            <img src="{{ asset('storage/' . $history->image) }}" alt="{{ $history->title }}" class="max-h-96 rounded-lg">
        </div>
        @endif

        <!-- Fondateur -->
        @if($history->founder_name || $history->founder_description)
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Informations sur le fondateur</h3>
            @if($history->founder_name)
            <p class="font-semibold">{{ $history->founder_name }}</p>
            @endif
            @if($history->founder_description)
            <p class="mt-2">{{ $history->founder_description }}</p>
            @endif
        </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-between items-center mt-4">
            <form action="{{ route('admin.history.destroy', $history) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet historique ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Supprimer cet historique
                </button>
            </form>
        </div>
    </div>
</div>
@endsection