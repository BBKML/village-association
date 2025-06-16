<!-- resources/views/admin/services/index.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Gestion des services locaux')

@section('admin-content')
<!-- Messages de notification -->
@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
    <p>{{ session('success') }}</p>
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Services locaux</h2>
    <a href="{{ route('admin.services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Ajouter un service
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($services as $service)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        @if($service->image)
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}">
                        </div>
                        @endif

                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                            <div class="text-sm text-gray-500">{{ $service->address }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $service->type }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $service->phone }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.services.show', $service) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600"
                               title="Voir">
                                <i class="fas fa-eye mr-1"></i> 
                            </a>
                        
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600"
                               title="Modifier">
                                <i class="fas fa-edit mr-1"></i> 
                            </a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
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
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                    Aucun service local enregistré
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $services->links() }}
</div>
@endsection