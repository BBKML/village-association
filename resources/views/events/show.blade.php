@extends('layouts.app')

@section('title', $event->title . ' - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-20 md:py-28 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1517502884422-41eaead166d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-2/3 mb-8 md:mb-0">
                <div class="inline-block px-4 py-2 bg-white text-blue-600 rounded-full text-sm font-bold mb-4">
                    {{ $event->category ?? 'Événement' }}
                </div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $event->title }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 text-lg">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt mr-2 text-blue-300"></i>
                        <span>{{ $event->start_date->translatedFormat('l d F Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="far fa-clock mr-2 text-blue-300"></i>
                        <span>{{ $event->start_date->format('H:i') }}</span>
                        @if($event->end_date)
                            <span class="mx-1">-</span>
                            <span>{{ $event->end_date->format('H:i') }}</span>
                        @endif
                    </div>
                    @if($event->location)
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-300"></i>
                        <span>{{ $event->location }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($event->registration_required)
            <div class="md:w-1/3 md:pl-8">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    @if($event->available_spots > 0)
                        <div class="text-green-600 font-bold text-lg mb-2">
                            <i class="fas fa-check-circle"></i> Places disponibles
                        </div>
                        <div class="text-gray-500 text-sm mb-4">
                            {{ $event->available_spots }} places restantes
                        </div>
                        <a href="{{ $event->registration_link ?? route('events.register', $event) }}" 
                           class="btn-primary inline-block w-full py-3 rounded-lg font-bold">
                           S'inscrire maintenant <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <div class="text-red-600 font-bold text-lg mb-2">
                            <i class="fas fa-times-circle"></i> Complet
                        </div>
                        <p class="text-gray-500 text-sm mb-4">
                            Cet événement ne dispose plus de places disponibles
                        </p>
                        <button class="btn-primary bg-gray-400 cursor-not-allowed inline-block w-full py-3 rounded-lg font-bold opacity-75">
                            Événement complet
                        </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="lg:w-2/3">
            <!-- Event Image -->
            @if($event->image)
            <div class="rounded-xl shadow-lg overflow-hidden mb-8">
                <img src="{{ asset('storage/' . $event->image) }}" 
                     alt="{{ $event->title }}"
                     class="w-full h-auto max-h-96 object-cover">
            </div>
            @endif
            
            <!-- Event Description -->
            <div class="prose max-w-none text-gray-700 text-lg mb-8">
                {!! $event->description !!}
            </div>
            
            <!-- Gallery -->
            @if($event->gallery && $event->gallery->items->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-images text-blue-600 mr-3"></i>
                    Galerie photo
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($event->gallery->items as $item)
                    <a href="{{ asset('storage/' . $item->file_path) }}" 
                    data-lightbox="event-gallery" 
                    data-title="{{ $item->caption ?? $event->title }}"
                    class="group rounded-lg overflow-hidden block">
                        <img src="{{ asset('storage/' . $item->file_path) }}" 
                            alt="{{ $item->caption ?? 'Image de l\'événement' }}"
                            class="w-full h-40 object-cover group-hover:opacity-90 transition">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Share Buttons -->
            <div class="bg-blue-50 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Partager cet événement</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                       <i class="fab fa-facebook-f mr-2"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                       <i class="fab fa-twitter mr-2"></i> Twitter
                    </a>
                    <a href="mailto:?subject={{ rawurlencode($event->title) }}&body={{ rawurlencode('Je te propose cet événement: ' . url()->current()) }}" 
                       class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                       <i class="fas fa-envelope mr-2"></i> Email
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/3">
            <!-- Practical Info -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations pratiques
                    </h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Date et heure</h3>
                                <p class="text-gray-600">
                                    {{ $event->start_date->translatedFormat('l d F Y') }}<br>
                                    De {{ $event->start_date->format('H:i') }}
                                    @if($event->end_date)
                                        à {{ $event->end_date->format('H:i') }}
                                    @endif
                                </p>
                            </div>
                        </li>
                        
                        @if($event->location)
                        <li class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Lieu</h3>
                                <p class="text-gray-600">{{ $event->location }}</p>
                                @if($event->location_link)
                                <a href="{{ $event->location_link }}" target="_blank" class="text-blue-600 hover:underline mt-1 inline-block">
                                    Voir sur la carte <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                </a>
                                @endif
                            </div>
                        </li>
                        @endif
                        
                        @if($event->price)
                        <li class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Tarif</h3>
                                <p class="text-gray-600">{{ $event->price }}</p>
                            </div>
                        </li>
                        @endif
                        
                        @if($event->contact_email || $event->contact_phone)
                        <li class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-4">
                                <i class="fas fa-user-headset"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Contact</h3>
                                @if($event->contact_email)
                                <p class="text-gray-600">
                                    <a href="mailto:{{ $event->contact_email }}" class="text-blue-600 hover:underline">
                                        {{ $event->contact_email }}
                                    </a>
                                </p>
                                @endif
                                @if($event->contact_phone)
                                <p class="text-gray-600">
                                    <a href="tel:{{ $event->contact_phone }}" class="text-blue-600 hover:underline">
                                        {{ $event->contact_phone }}
                                    </a>
                                </p>
                                @endif
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <!-- Organizer Info -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Organisateur
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('storage/' . $association->main_image) }}" 
                             alt="{{ $association->name }}"
                             class="w-12 h-12 rounded-full object-cover mr-4 border-2 border-blue-200">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $association->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $association->short_description }}</p>
                        </div>
                    </div>
                    <a href="{{ route('association.about') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Related Events -->
            @if($relatedEvents->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Événements similaires
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($relatedEvents as $relatedEvent)
                        <a href="{{ route('events.show', $relatedEvent) }}" class="group flex items-start hover:bg-blue-50 p-2 rounded-lg transition">
                            @if($relatedEvent->image)
                            <img src="{{ asset('storage/' . $relatedEvent->image) }}" 
                                 alt="{{ $relatedEvent->title }}"
                                 class="w-16 h-16 object-cover rounded-lg mr-4">
                            @else
                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-day text-blue-600"></i>
                            </div>
                            @endif
                            <div>
                                <h3 class="font-medium text-gray-800 group-hover:text-blue-600">{{ $relatedEvent->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $relatedEvent->start_date->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Vous souhaitez plus d'informations ?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Notre équipe est à votre disposition pour répondre à toutes vos questions concernant cet événement ou nos autres activités.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact.create') }}" class="btn-primary px-6 py-3 rounded-full font-bold">
                Nous contacter <i class="fas fa-envelope ml-2"></i>
            </a>
            <a href="{{ route('events.index') }}" class="btn-accent bg-white text-gray-800 border border-gray-300 px-6 py-3 rounded-full font-bold hover:bg-gray-100">
                Voir tous les événements <i class="fas fa-calendar-alt ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Lightbox for gallery -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Image %1 sur %2"
    });
</script>

<!-- Add to calendar button -->
<script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@2" async defer></script>
@endsection