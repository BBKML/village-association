@extends('layouts.admin')

@section('title', 'Gestion des Activités')

@section('admin-content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-blue-600">Liste des Activités</h2>
        <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Ajouter une activité
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border-b">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Titre</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Date</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Lieu</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border-b text-center">
                        @if($activity->image)
                            <img src="{{ asset('storage/' . $activity->image) }}" alt="Image" class="h-16 w-16 object-cover rounded shadow">
                        @else
                            <span class="text-gray-500 italic">Aucune</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b text-gray-800">{{ $activity->title }}</td>
                    <td class="px-4 py-3 border-b">{{ $activity->date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border-b">{{ $activity->location }}</td>
                    <td class="px-4 py-3 border-b text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.activities.show', $activity) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.activities.edit', $activity) }}" class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Supprimer cette activité ?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">Aucune activité enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
