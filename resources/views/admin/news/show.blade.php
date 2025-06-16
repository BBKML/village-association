<!-- resources/views/admin/news/show.blade.php -->
@extends('layouts.admin')

@section('admin-title', $news->title)

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold">{{ $news->title }}</h2>
            <div class="mt-2 flex items-center space-x-4">
                <span class="px-2 py-1 text-xs rounded-full {{ $news->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $news->is_published ? 'Publié' : 'Brouillon' }}
                </span>
                <span class="text-sm text-gray-500">
                    {{ $news->published_at->format('d/m/Y') }}
                </span>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.news.edit', $news) }}" class="text-blue-600 hover:text-blue-800">
                Éditer
            </a>
            <form action="{{ route('admin.news.destroy', $news) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    @if ($news->image)
        <div class="mb-6">
            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="rounded-lg max-w-full h-auto">
        </div>
    @endif

    <div class="prose max-w-none">
        {!! nl2br(e($news->content)) !!}  <!-- e() pour échapper le HTML -->
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.news.index') }}" class="text-blue-600 hover:underline">&larr; Retour à la liste</a>
    </div>
</div>
@endsection
