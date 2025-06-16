@extends('layouts.app')

@section('title', $news->title . ' - ' . ($association->name ?? 'Actualités'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-20 md:py-28 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1585829365295-ab7cd400c7e6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-block px-4 py-2 bg-white text-blue-600 rounded-full text-sm font-bold mb-4">
                {{ $news->category ?? 'Actualité' }}
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $news->title }}</h1>
            
            <div class="flex flex-wrap justify-center items-center gap-4 text-blue-100">
                <div class="flex items-center">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span>{{ $news->published_at->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="far fa-clock mr-2"></i>
                    <span>{{ $news->published_at->format('H:i') }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $news->author ?? 'Équipe éditoriale' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <!-- Featured Image -->
        @if($news->image)
        <div class="rounded-xl shadow-xl overflow-hidden mb-12">
            <img src="{{ asset('storage/' . $news->image) }}" 
                 alt="{{ $news->title }}" 
                 class="w-full h-auto max-h-[500px] object-cover">
        </div>
        @endif

        <!-- Article Content -->
        <article class="prose prose-lg max-w-none text-gray-700">
            {!! $news->content !!}
        </article>

        <!-- Tags -->
        @if($news->tags)
        <div class="mt-12">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Mots-clés</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $news->tags) as $tag)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                    {{ trim($tag) }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-12 bg-blue-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Partager cet article</h3>
            <div class="flex flex-wrap gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                   <i class="fab fa-facebook-f mr-2"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                   <i class="fab fa-twitter mr-2"></i> Twitter
                </a>
                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}" 
                   target="_blank"
                   class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                   <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                </a>
                <a href="mailto:?subject={{ rawurlencode($news->title) }}&body={{ rawurlencode('Je te partage cet article: ' . url()->current()) }}" 
                   class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                   <i class="fas fa-envelope mr-2"></i> Email
                </a>
            </div>
        </div>

        <!-- Author Bio -->
        @if($news->author_bio)
        <div class="mt-12 bg-gray-50 rounded-xl p-6 flex items-start">
            <div class="flex-shrink-0 mr-4">
                <img src="{{ asset('storage/' . $news->author_image) }}" 
                     alt="{{ $news->author }}" 
                     class="w-16 h-16 rounded-full object-cover">
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $news->author }}</h3>
                <p class="text-gray-600 mt-1">{{ $news->author_role }}</p>
                <p class="text-gray-700 mt-3">{{ $news->author_bio }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Related Articles -->
@if(isset($relatedNews) && $relatedNews->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Articles <span class="text-blue-600">similaires</span></h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedNews as $item)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                        <span>{{ $item->published_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $item->title }}</h3>
                    <a href="{{ route('news.show', $item) }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                       Lire l'article <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Newsletter -->
<section class="bg-blue-700 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-6">Ne manquez aucun article</h2>
            <p class="text-lg text-blue-100 mb-8">Abonnez-vous à notre newsletter pour recevoir les dernières actualités directement dans votre boîte mail.</p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Votre email" class="flex-grow px-4 py-3 rounded-lg focus:outline-none text-gray-800">
                <button type="submit" class="btn-primary bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">
                    S'abonner <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .prose {
        line-height: 1.8;
    }
    .prose h2 {
        color: #1e3a8a;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
    }
    .prose h3 {
        color: #1e40af;
        font-weight: 600;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
    }
    .prose img {
        border-radius: 0.5rem;
        margin-top: 1.5em;
        margin-bottom: 1.5em;
    }
    .prose a {
        color: #2563eb;
        font-weight: 500;
        text-decoration: underline;
    }
    .prose a:hover {
        color: #1d4ed8;
    }
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1.5rem;
        font-style: italic;
        color: #4b5563;
        margin: 1.5em 0;
    }
</style>
@endsection