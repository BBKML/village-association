@extends('layouts.admin')

@section('title', 'Gestion des Projets')

@section('admin-content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-blue-600">Liste des Projets</h2>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Ajouter un projet
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Titre</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Statut</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Dates</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Besoins</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border-b">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="Projet" class="w-16 h-16 object-cover rounded shadow">
                        @else
                            <span class="text-gray-400 italic text-sm">Aucune</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b text-gray-800">{{ $project->title }}</td>
                    <td class="px-4 py-3 border-b">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-{{ $project->status_class }}-100 text-{{ $project->status_class }}-800">
                            {{ $project->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 border-b">
                        {{ $project->start_date->format('d/m/Y') }}
                        @if($project->end_date)
                            <br><span class="text-sm text-gray-600">au {{ $project->end_date->format('d/m/Y') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b">
                        @if($project->needs_volunteers)
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded mr-1">Bénévoles</span>
                        @endif
                        @if($project->needs_donations)
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">Dons</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')" class="inline">
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
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">Aucun projet enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection