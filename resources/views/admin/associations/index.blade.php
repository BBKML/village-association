@extends('layouts.admin')

@section('admin-title', 'Gestion des Associations')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Liste des Associations</h2>
        <a href="{{ route('admin.associations.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i> Ajouter une association
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nom</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Image</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Description</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($associations as $association)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $association->name }}</td>
                        <td class="px-4 py-2">
                            @if($association->main_image)
                                <img src="{{ asset('storage/' . $association->main_image) }}" alt="{{ $association->name }}" class="h-16 rounded-md object-cover">
                            @else
                                <span class="text-sm text-gray-400 italic">Aucune image</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            {{ Str::limit($association->description, 50) }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.associations.show', $association) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600"
                            title="Voir"
                            aria-label="Voir l'association {{ $association->name }}">
                                <i class="fas fa-eye mr-1"></i> 
                            </a>
                            <a href="{{ route('admin.associations.edit', $association) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600"
                               title="Modifier">
                                <i class="fas fa-edit mr-1"></i> 
                            </a>
                            <form action="{{ route('admin.associations.destroy', $association) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700"
                                        title="Supprimer">
                                    <i class="fas fa-trash mr-1"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Aucune association trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $associations->links() }}
    </div>
</div>
@endsection
