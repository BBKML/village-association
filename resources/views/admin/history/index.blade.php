@extends('layouts.admin')

@section('admin-title', 'Historique du village')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Historique du village</h2>
        <a href="{{ route('admin.history.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
            Ajouter un historique
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 text-green-700 bg-green-50 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 text-red-700 bg-red-50 border border-red-200 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($histories->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Créé le</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($histories as $history)
                <tr>
                    <td class="px-6 py-4">
                        @if($history->image)
                            <img src="{{ asset('storage/' . $history->image) }}" alt="Image" class="h-16 w-16 object-cover rounded-md shadow-sm">
                        @else
                            <span class="text-gray-500 italic">Aucune image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $history->title }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $history->slug }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $history->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                       
                           <a href="{{ route('admin.history.show', $history) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600"
                               title="Voir">
                                <i class="fas fa-eye mr-1"></i> 
                            </a>
                        
                            <a href="{{ route('admin.history.edit', $history) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600"
                               title="Modifier">
                                <i class="fas fa-edit mr-1"></i> 
                            </a>
                        <form action="{{ route('admin.history.destroy', $history) }}" method="POST" class="inline">
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
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $histories->links() }}
    </div>
    @else
    <div class="text-center text-gray-500 py-8">
        Aucun historique n’a encore été ajouté.
    </div>
    @endif
</div>
@endsection
