@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-center mb-8">
        Les Membres du Bureau
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($boardMembers as $member)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-300 hover:scale-105">
                <div class="relative">
                    @if($member->image)
                        <img 
                            src="{{ asset('storage/' . $member->image) }}" 
                            alt="{{ $member->first_name }} {{ $member->last_name }}" 
                            class="w-full h-64 object-cover"
                        >
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-4xl text-gray-500">
                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                        <h2 class="text-xl font-semibold">
                            {{ $member->first_name }} {{ $member->last_name }}
                        </h2>
                        <p class="text-sm text-gray-200">
                            {{ $member->role ?? 'Membre du Bureau' }}
                        </p>
                    </div>
                </div>
                
                @if($member->bio)
                    <div class="p-4">
                        <p class="text-gray-600 text-sm">
                            {{ Str::limit($member->bio, 150) }}
                        </p>
                    </div>
                @endif

                <div class="p-4 flex items-center justify-between border-t">
                    @if($member->email)
                        <a 
                            href="mailto:{{ $member->email }}" 
                            class="text-blue-500 hover:text-blue-700 flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            Contacter
                        </a>
                    @endif

                    @if($member->phone)
                        <a 
                            href="tel:{{ $member->phone }}" 
                            class="text-green-500 hover:text-green-700 flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.036 11.036 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            Appeler
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-600 text-xl">
                    Aucun membre du bureau n'a été trouvé.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection