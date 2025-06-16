@extends('layouts.app')

@section('title', 'Notre Histoire - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Notre <span class="text-yellow-300">Histoire</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Un voyage à travers les moments clés qui ont façonné notre association
        </p>
        <div class="animate-fadeInUp" style="animation-delay: 0.5s">
            <a href="#history" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Découvrir notre parcours <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Main History Section -->
<section id="history" class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        @if($histories->count() > 0)
            @foreach($histories as $history)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
                @if($history->image)
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('storage/' . $history->image) }}" 
                         alt="{{ $history->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                @endif

                <div class="p-8 md:p-12">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-1 bg-blue-600 mr-4"></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $history->title }}</h2>
                    </div>

                    @if($history->content)
                    <div class="prose max-w-none text-gray-700 text-lg">
                        {!! $history->content !!}
                    </div>
                    @endif

                    @if($history->founder_name || $history->founder_description)
                    <div class="mt-8 p-6 bg-gray-50 rounded-xl">
                        @if($history->founder_name)
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $history->founder_name }}</h3>
                        @endif
                        @if($history->founder_description)
                        <p class="text-gray-600">{{ $history->founder_description }}</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center text-gray-500 py-8">
                <p>Aucune donnée d'historique n'est disponible.</p>
            </div>
        @endif
    </div>
</section>

<!-- Timeline Section -->
@if(isset($timeline) && count($timeline) > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Nos <span class="text-blue-600">Dates Clés</span></h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-12"></div>
        
        <div class="relative">
            <!-- Timeline line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-blue-500 to-indigo-600"></div>
            
            <!-- Timeline items -->
            <div class="space-y-16">
                @foreach($timeline as $index => $event)
                <div class="relative flex {{ $index % 2 == 0 ? 'justify-start' : 'justify-end' }}">
                    <div class="w-full md:w-1/2 px-4">
                        <div class="bg-white p-6 rounded-xl shadow-lg relative">
                            <!-- Year badge -->
                            <div class="absolute -top-4 {{ $index % 2 == 0 ? '-left-4' : '-right-4' }} bg-blue-600 text-white px-4 py-2 rounded-lg font-bold shadow-md">
                                {{ $event['year'] }}
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event['title'] }}</h3>
                            <p class="text-gray-600">{{ $event['event'] }}</p>
                            
                            @if(isset($event['image']))
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $event['image']) }}" 
                                     alt="{{ $event['title'] }}" 
                                     class="w-full h-auto rounded-lg shadow">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Values Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Nos <span class="text-blue-600">Valeurs</span> à travers le temps</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-12"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-blue-50 rounded-xl p-8 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hands-helping text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Solidarité</h3>
                <p class="text-gray-600">Depuis nos débuts, nous croyons en la force du collectif et de l'entraide pour construire un avenir meilleur.</p>
            </div>
            
            <div class="bg-blue-50 rounded-xl p-8 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Engagement</h3>
                <p class="text-gray-600">Chaque membre s'engage pleinement dans les projets et actions de l'association, comme depuis le premier jour.</p>
            </div>
            
            <div class="bg-blue-50 rounded-xl p-8 text-center hover:shadow-lg transition">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Innovation</h3>
                <p class="text-gray-600">Nous avons toujours su nous renouveler pour répondre aux besoins changeants de notre communauté.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-700 to-blue-900 py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">Faites partie de la suite de notre histoire</h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
            Rejoignez-nous pour écrire ensemble les prochains chapitres de cette belle aventure
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact.create') }}" 
               class="btn-primary bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100">
               Devenir membre <i class="fas fa-user-plus ml-2"></i>
            </a>
            <a href="{{ route('contact.create') }}" 
               class="btn-accent bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-500">
               Devenir bénévole <i class="fas fa-hands-helping ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection