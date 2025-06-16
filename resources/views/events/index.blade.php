@extends('layouts.app')

@section('title', 'Événements - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-700 to-purple-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Nos <span class="text-yellow-300">Événements</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Découvrez notre agenda rempli d'activités passionnantes pour toute la communauté
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#events" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Voir le calendrier <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16" id="events">
    <!-- Calendar Navigation -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-12 bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">
            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
            Prochains Événements
        </h2>
        <div class="flex items-center space-x-4">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium flex items-center">
                <i class="fas fa-calendar-day mr-2"></i> Vue Mois
            </button>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm font-medium flex items-center transition">
                <i class="fas fa-list mr-2"></i> Vue Liste
            </button>
            <a href="{{ route('events.calendar') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm font-medium flex items-center transition">
                <i class="fas fa-calendar mr-2"></i> Calendrier complet
            </a>
        </div>
    </div>

    @if($events->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calendar-times text-3xl text-indigo-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Aucun événement programmé actuellement</h2>
            <p class="text-gray-600 mb-6">Nous préparons de nouveaux événements passionnants. Abonnez-vous à notre newsletter pour être informé des prochaines dates.</p>
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
        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group">
                    <!-- Event Image -->
                    <div class="relative h-56 overflow-hidden">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-calendar-check text-4xl text-white opacity-80"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4">
                            <span class="inline-block px-3 py-1 bg-white text-indigo-600 text-xs font-bold rounded-full shadow">
                                {{ $event->category }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Event Details -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-800">{{ $event->title }}</h3>
                            @if($event->is_free)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded">
                                    Gratuit
                                </span>
                            @endif
                        </div>
                        
                        <!-- Date and Time -->
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                            <span>{{ $event->start_date->translatedFormat('l d F Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="far fa-clock mr-2 text-indigo-500"></i>
                            <span>{{ $event->start_date->format('H:i') }}</span>
                            @if($event->end_date)
                                <span class="mx-1">-</span>
                                <span>{{ $event->end_date->format('H:i') }}</span>
                            @endif
                        </div>
                        
                        <!-- Location -->
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        
                        <p class="text-gray-600 mb-6">{{ Str::limit($event->description, 120) }}</p>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('events.show', $event) }}"
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                Plus d'infos <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            
                            @if($event->registration_required)
                                @if($event->available_spots > 0)
                                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                        {{ $event->available_spots }} places restantes
                                    </span>
                                @else
                                    <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                        Complet
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $events->links() }}
        </div>
    @endif
</div>

<!-- Featured Event -->
@if(isset($featuredEvent) && $featuredEvent)
<section class="bg-gradient-to-r from-indigo-600 to-indigo-800 py-16 text-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-8 lg:mb-0 lg:pr-12">
                <span class="inline-block px-3 py-1 bg-white text-indigo-600 rounded-full text-sm font-bold mb-4">
                    Événement à la une
                </span>
                <h2 class="text-3xl font-bold mb-4">{{ $featuredEvent->title }}</h2>
                <div class="flex items-center text-indigo-200 mb-4">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span>{{ $featuredEvent->start_date->translatedFormat('l d F Y') }}</span>
                    <span class="mx-2">•</span>
                    <i class="far fa-clock mr-2"></i>
                    <span>{{ $featuredEvent->start_date->format('H:i') }}</span>
                </div>
                <p class="text-lg text-indigo-100 mb-6">{{ Str::limit($featuredEvent->description, 200) }}</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('events.show', $featuredEvent) }}" class="btn-primary bg-white text-indigo-600 px-6 py-3 rounded-full font-bold hover:bg-gray-100">
                        Détails de l'événement <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @if($featuredEvent->registration_link)
                    <a href="{{ $featuredEvent->registration_link }}" target="_blank" class="btn-accent bg-yellow-400 text-gray-900 px-6 py-3 rounded-full font-bold hover:bg-yellow-500">
                        S'inscrire maintenant <i class="fas fa-user-plus ml-2"></i>
                    </a>
                    @endif
                </div>
            </div>
            <div class="lg:w-1/2">
                <div class="relative rounded-xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('storage/' . $featuredEvent->image) }}" 
                         alt="{{ $featuredEvent->title }}"
                         class="w-full h-auto">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Event Categories -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Nos catégories d'événements</h2>
        <div class="w-24 h-1 bg-indigo-500 mx-auto mb-8"></div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-music text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Culturels</h3>
                <p class="text-gray-600 text-sm">Concerts, expositions, spectacles</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-running text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Sportifs</h3>
                <p class="text-gray-600 text-sm">Compétitions, tournois, activités</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Éducatifs</h3>
                <p class="text-gray-600 text-sm">Conférences, ateliers, formations</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-utensils text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Conviviaux</h3>
                <p class="text-gray-600 text-sm">Repas, fêtes, rencontres</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="bg-indigo-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">Ne manquez aucun événement</h2>
            <p class="text-lg text-indigo-100 mb-8">Abonnez-vous à notre newsletter pour recevoir les dernières actualités et invitations aux événements.</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Votre email" class="flex-grow px-4 py-3 rounded-lg focus:outline-none text-gray-800">
                <button type="submit" class="btn-primary bg-white text-indigo-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">
                    S'abonner <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection