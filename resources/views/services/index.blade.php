@extends('layouts.app')

@section('title', 'Services Locaux - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Services <span class="text-yellow-300">Locaux</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Découvrez les services proposés par et pour notre communauté
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#services" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Explorer les services <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16" id="services">
    <!-- Services Filter -->
    <div class="mb-12 bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Filtrer les services</h2>
        <div class="flex flex-wrap gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium">Tous les services</button>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-medium transition">Social</button>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-medium transition">Éducatif</button>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-medium transition">Culturel</button>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-medium transition">Santé</button>
        </div>
    </div>

    @if($services->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-concierge-bell text-3xl text-blue-600"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Aucun service disponible actuellement</h2>
            <p class="text-gray-600 mb-6">Nous travaillons à proposer de nouveaux services pour la communauté. Revenez bientôt !</p>
            <a href="{{ route('contact.create') }}" class="btn-primary px-6 py-3 rounded-full font-bold">
                Nous contacter <i class="fas fa-envelope ml-2"></i>
            </a>
        </div>
    @else
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group">
                <!-- Service Image -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         alt="{{ $service->name }}" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="inline-block px-3 py-1 bg-white text-blue-600 rounded-full text-xs font-bold shadow">
                            {{ ucfirst($service->type) }}
                        </span>
                    </div>
                </div>
                
                <!-- Service Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition">{{ $service->name }}</h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                        <span>{{ $service->location }}</span>
                    </div>
                    
                    <p class="text-gray-600 mb-6 line-clamp-2">{{ $service->description }}</p>
                    
                    <div class="flex justify-between items-center">
                        <a href="{{ route('services.show', $service) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                           En savoir plus <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        
                        @if($service->is_free)
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-euro-sign mr-1"></i> Gratuit
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $services->links() }}
        </div>
    @endif
</div>

<!-- Service Categories -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Types de <span class="text-blue-600">services</span></h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hands-helping text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Services Sociaux</h3>
                <p class="text-gray-600 text-sm">Aide et accompagnement pour tous</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Services Éducatifs</h3>
                <p class="text-gray-600 text-sm">Formations et soutien scolaire</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-theater-masks text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Services Culturels</h3>
                <p class="text-gray-600 text-sm">Activités artistiques et événements</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Services de Santé</h3>
                <p class="text-gray-600 text-sm">Bien-être et prévention</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">Vous proposez un service ?</h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
            Rejoignez notre annuaire des services locaux et augmentez votre visibilité
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact.create') }}" class="btn-primary bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100">
                Proposer un service <i class="fas fa-plus-circle ml-2"></i>
            </a>
            <a href="{{ route('contact.create') }}" class="btn-accent bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500">
                Nous contacter <i class="fas fa-envelope ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection