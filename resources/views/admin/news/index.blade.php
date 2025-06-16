<!-- resources/views/admin/news/index.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Liste des actualités')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Actualités</h2>
        <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nouvelle actualité
        </a>
    </div>

    <table class="w-full table-auto border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Image</th>
                <th class="px-4 py-2 text-left">Titre</th>
                <th class="px-4 py-2 text-left">Statut</th>
                <th class="px-4 py-2 text-left">Mise en avant</th>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $item)
                <tr class="border-t align-middle">
                    <!-- Image -->
                    <td class="px-4 py-3 border-b text-center">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Image" class="w-16 h-16 rounded object-cover shadow-sm mx-auto">
                        @else
                            <span class="text-gray-400 text-sm italic">Aucune</span>
                        @endif
                    </td>

                    <!-- Titre -->
                    <td class="px-4 py-3 border-b text-gray-800 font-medium">{{ $item->title }}</td>

                    <!-- Statut -->
                    <td class="px-4 py-3 border-b">
                        <span class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->is_published ? 'Publié' : 'Brouillon' }}
                        </span>
                    </td>
                    
                    <!-- Mise en avant -->
                    <td class="px-4 py-3 border-b">
                        @if($item->is_featured)
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> À la une
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    
                    <!-- Date -->
                    <td class="px-4 py-3 border-b">{{ $item->published_at->format('d/m/Y') }}</td>

                    <!-- Actions -->
                    <td class="px-4 py-3 border-b space-x-2">
                        <a href="{{ route('admin.news.show', $item) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600"
                           title="Voir">
                            <i class="fas fa-eye mr-1"></i> 
                        </a>
                        <a href="{{ route('admin.news.edit', $item) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600"
                           title="Modifier">
                            <i class="fas fa-edit mr-1"></i> 
                        </a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette actualité ?')">
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
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">Aucune actualité trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $news->links() }}
    </div>
</div>
@endsection