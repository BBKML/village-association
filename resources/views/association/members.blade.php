@extends('layouts.app')

@section('title', 'Membres - ' . ($association->name ?? 'Association'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Nos membres</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($members as $member)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($member->image)
            <img src="{{ asset('storage/'.$member->image) }}" 
                 alt="{{ $member->full_name }}"
                 class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <h3 class="text-xl font-semibold">{{ $member->first_name }} {{ $member->last_name }}</h3>
                <p class="text-blue-600">{{ $member->role }}</p>
                <p class="text-gray-600 mt-2">Membre depuis {{ $member->joined_date->format('d/m/Y') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $members->links() }}
    </div>
</div>
@endsection