<!-- resources/views/admin/news/index.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Gestion des actualités')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Actualités</h2>
    <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Créer une actualité
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($news as $item)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium">{{ $item->title }}</div>
                    @if($item->image)
                    <div class="mt-1">
                        <span class="text-xs text-gray-500">Avec image</span>
                    </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $item->published_at->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <form action="{{ route('admin.news.toggle-publish', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->is_published ? 'Publié' : 'Brouillon' }}
                        </button>
                    </form>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.news.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">Éditer</a>
                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $news->links() }}
</div>
@endsection