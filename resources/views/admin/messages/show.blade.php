<!-- resources/views/admin/messages/show.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Message de ' . $message->name)

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold">Message de {{ $message->name }}</h2>
            <div class="mt-2 flex items-center space-x-4">
                <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:underline">{{ $message->email }}</a>
                <span class="text-sm text-gray-500">{{ $message->created_at->format('d/m/Y à H:i') }}</span>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $message->is_read ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $message->is_read ? 'Lu' : 'Non lu' }}
                </span>
            </div>
        </div>
        <div>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
        <div class="prose max-w-none">
            {!! nl2br(e($message->message)) !!}
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="mailto:{{ $message->email }}?subject=RE: Votre message du {{ $message->created_at->format('d/m/Y') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            Répondre
        </a>

        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Retour à la liste
        </a>
    </div>
</div>
@endsection