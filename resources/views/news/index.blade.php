@extends('layouts.app')

@section('title', 'Actualités - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1585829365295-ab7cd400c7e6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Nos <span class="text-yellow-300">Actualités</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Restez informés des dernières nouvelles et événements de notre association
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#news" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Explorer les articles <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16" id="news">

    @if(isset($news) && $news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($news as $item)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 group">
                    <!-- Image with category badge -->
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" 
                            alt="{{ $item->title }}" 
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-white text-blue-600 text-xs font-bold rounded-full shadow">
                                {{ $item->category ?? 'Actualité' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                            <span>{{ $item->published_at->translatedFormat('d F Y') }}</span>
                            <span class="mx-2">•</span>
                            <i class="far fa-clock mr-2 text-blue-500"></i>
                            <span>{{ $item->published_at->format('H:i') }}</span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition">
                            {{ $item->title }}
                        </h2>
                        
                        <p class="text-gray-600 mb-5 line-clamp-2">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                        
                        <div class="flex justify-between items-center">
                            <a href="{{ route('news.show', $item) }}" 
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            Lire la suite <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            
                            @if($item->is_featured)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">
                                    <i class="fas fa-star mr-1"></i> À la une
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <h3 class="text-xl text-gray-600">Aucune actualité disponible pour le moment.</h3>
        </div>
    @endif

    <!-- Newsletter Subscription -->
    <div class="mt-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 md:p-12">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Ne manquez aucune actualité</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Abonnez-vous à notre newsletter pour recevoir les dernières nouvelles directement dans votre boîte mail
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Votre adresse email" 
                       class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" 
                        class="btn-primary bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                        S'abonner <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Featured Articles -->
@if(isset($featuredNews) && $featuredNews->count() > 0)
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Articles <span class="text-blue-600">à la une</span></h2>
            <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($featuredNews as $item)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3">
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-2/3 p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                                    <span>{{ $item->published_at->translatedFormat('d F Y') }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $item->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                                <a href="{{ route('news.show', $item) }}" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                   Lire l'article <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection

@section('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
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
</style>
@endsection