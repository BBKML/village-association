@extends('layouts.admin')

@section('title', 'Gestion des Galeries')

@section('admin-content')
<div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-blue-600">
            <i class="fas fa-images mr-2"></i>Liste des Galeries
        </h2>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Ajouter une galerie
        </a>
    </div>

    @if($galleries->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded">
            <i class="fas fa-images text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600">Aucune galerie disponible</p>
            <a href="{{ route('admin.galleries.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Créer une galerie
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Titre</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Médias</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Date</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $gallery)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border-b">
                            <div class="flex items-center">
                                @if($gallery->items->first())
                                    <div class="h-10 w-10 mr-3">
                                        @if($gallery->items->first()->file_type === 'image')
                                            <img class="h-10 w-10 object-cover rounded shadow" 
                                                 src="{{ asset('storage/' . $gallery->items->first()->file_path) }}" 
                                                 alt="Miniature">
                                        @else
                                            <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-video text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-800">{{ $gallery->title }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ $gallery->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 border-b">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $gallery->type === 'activity' ? 'bg-blue-100 text-blue-800' : 
                                   ($gallery->type === 'project' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($gallery->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 border-b text-gray-700">
                            <span class="font-medium">{{ $gallery->items_count }}</span> élément(s)
                        </td>
                        <td class="px-4 py-3 border-b text-gray-700">
                            {{ $gallery->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 border-b text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.galleries.show', $gallery) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Supprimer cette galerie ?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection
