@extends('layouts.app')

@section('title', 'Activités - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-purple-700 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1517502884422-41eaead166d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Nos <span class="text-yellow-300">Activités</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Découvrez nos actions et engagements qui dynamisent notre communauté
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#activities" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Explorer nos activités <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16" id="activities">
    @if($activities->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calendar-times text-3xl text-blue-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Aucune activité programmée actuellement</h2>
            <p class="text-gray-600 mb-6">Nous préparons de nouvelles activités passionnantes. Abonnez-vous à notre newsletter pour être informé des prochains événements.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact.create') }}" class="btn-primary px-6 py-3 rounded-full font-bold">
                    Nous contacter <i class="fas fa-envelope ml-2"></i>
                </a>
                <a href="{{ route('contact.create') }}" class="btn-accent px-6 py-3 rounded-full font-bold">
                    S'abonner <i class="fas fa-bell ml-2"></i>
                </a>
            </div>
        </div>
    @else
        <!-- Filter Section -->
        <div class="mb-12 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filtrer les activités</h2>
            <form action="{{ route('activities.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-wrap gap-4">
                    <div class="flex-1">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="category" id="category" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <select name="date" id="date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">Toutes les dates</option>
                            <option value="upcoming" {{ request('date') == 'upcoming' ? 'selected' : '' }}>À venir</option>
                            <option value="past" {{ request('date') == 'past' ? 'selected' : '' }}>Passées</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Activities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($activities as $activity)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group">
                    <!-- Image with overlay -->
                    <div class="relative h-64 overflow-hidden">
                        @if($activity->image)
                            <img src="{{ asset('storage/' . $activity->image) }}"
                                 alt="{{ $activity->title }}"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            @if($activity->category)
                                <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-full mb-2">
                                    {{ $activity->category }}
                                </span>
                            @endif
                            <h2 class="text-xl font-bold text-white">{{ $activity->title }}</h2>
                        </div>
                    </div>
                    
                    <!-- Activity details -->
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <div class="flex items-center mr-4">
                                <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                <span>{{ $activity->date->translatedFormat('d F Y') }}</span>
                            </div>
                            @if($activity->time)
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                                    <span>{{ $activity->time }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                            <span>{{ $activity->location }}</span>
                        </div>
                        
                        <p class="text-gray-600 mb-6">{{ Str::limit($activity->description, 150) }}</p>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('activities.show', $activity->slug) }}"
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                Voir détails <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            
                            @if($activity->available_spots > 0)
                                <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">
                                    {{ $activity->available_spots }} places disponibles
                                </span>
                            @else
                                <span class="text-sm text-red-600 bg-red-100 px-3 py-1 rounded-full">
                                    Complet
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $activities->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-700 to-blue-900 py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">Vous souhaitez proposer ou organiser une activité ?</h2>
            <p class="text-lg text-blue-100 mb-8">Nous encourageons les initiatives et sommes toujours ouverts à de nouvelles idées pour enrichir notre programme d'activités.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact.create') }}"
                   class="btn-primary bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100">
                   Proposer une activité <i class="fas fa-lightbulb ml-2"></i>
                </a>
                <a href="#"
                   class="btn-accent bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500">
                   Devenir bénévole <i class="fas fa-hands-helping ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Événements à venir</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-6 flex items-start">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 mr-4">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Journée portes ouvertes</h3>
                    <p class="text-gray-600 text-sm mb-2">15 Septembre 2023 • 10h-18h</p>
                    <a href="#" class="text-blue-600 text-sm font-medium">En savoir plus →</a>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 flex items-start">
                <div class="bg-blue-100 text-blue-600 rounded-lg p-3 mr-4">
                    <i class="fas fa-running text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Course solidaire</h3>
                    <p class="text-gray-600 text-sm mb-2">30 Septembre 2023 • Parc municipal</p>
                    <a href="#" class="text-blue-600 text-sm font-medium">En savoir plus →</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection