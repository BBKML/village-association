@extends('layouts.admin')

@section('title', 'Gestion des Événements')

@section("admin-content")

<div class="bg-white shadow-md rounded p-6 mb-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-blue-600">Liste des Événements</h2>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <i class="fas fa-plus"></i> Ajouter un événement
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border rounded-lg">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">Image</th>
                    <th class="px-4 py-2 text-left">Titre</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Lieu</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($events as $event)
                <tr>
                    <td class="px-4 py-2">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-20 h-20 object-cover rounded shadow">
                        @else
                            <span class="text-gray-400 italic">Aucune image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $event->title }}</td>
                    <td class="px-4 py-2">
                        {{ $event->start_date->format('d/m/Y') }}
                        @if($event->end_date && $event->end_date->ne($event->start_date))
                            <br><span class="text-sm text-gray-600">au {{ $event->end_date->format('d/m/Y') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $event->location }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.events.show', $event) }}" class="inline-block px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}" class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>

@endsection
