@extends('layouts.admin')

@section('title', "Détails de l'Activité")

@section('admin-content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-blue-600">Détails de l'Activité</h2>
        <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
            <h3 class="text-xl font-bold text-gray-700">{{ $activity->title }}</h3>
            <p><strong class="text-gray-600">Date :</strong> {{ $activity->date->format('d/m/Y') }}</p>
            <p><strong class="text-gray-600">Lieu :</strong> {{ $activity->location }}</p>
            <p><strong class="text-gray-600">Description :</strong></p>
            <div class="text-gray-700 whitespace-pre-line">{{ $activity->description }}</div>
        </div>
        <div>
            @if($activity->image)
                <img src="{{ asset('storage/' . $activity->image) }}" alt="Image de l'activité" class="w-full h-auto rounded shadow">
            @else
                <div class="text-gray-500 italic">Aucune image disponible</div>
            @endif
        </div>
    </div>

    @if($activity->gallery && $activity->gallery->items->isNotEmpty())
        <div class="mt-8">
            <h4 class="text-lg font-semibold text-gray-700 mb-4">Galerie associée</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($activity->gallery->items as $item)
                    @if($item->file_type === 'image')
                        <div class="relative">
                            <img src="{{ asset('storage/' . $item->file_path) }}" 
                                alt="{{ $item->caption }}" 
                                class="w-full h-32 object-cover rounded shadow"
                                loading="lazy">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.activities.edit', $activity) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
            <i class="fas fa-edit mr-2"></i> Modifier
        </a>
    </div>
</div>
@endsection
