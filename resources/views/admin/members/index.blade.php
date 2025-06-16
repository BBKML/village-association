@extends('layouts.admin')

@section("admin-content")

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Membres de l'Association</h1>
        <a href="{{ route('admin.members.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Ajouter un Membre
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Photo</th>
                    <th class="py-3 px-6 text-left">Nom</th>
                    <th class="py-3 px-6 text-left">Rôle</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-center">Membre du Bureau</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($members as $member)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            @if($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->first_name }} {{ $member->last_name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $member->role ?? 'Non spécifié' }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $member->email ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            @if($member->is_board_member)
                                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Oui</span>
                            @else
                                <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs">Non</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex item-center justify-end space-x-2">
                                <a href="{{ route('admin.members.edit', $member) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($members->isEmpty())
            <div class="text-center py-6 text-gray-500">
                Aucun membre n'a été trouvé.
            </div>
        @endif

        <div class="px-6 py-4">
            {{ $members->links() }}
        </div>
    </div>
</div>
@endsection