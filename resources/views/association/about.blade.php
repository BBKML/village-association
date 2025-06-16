@extends('layouts.app')

@section('title', 'À propos - ' . $association->name)

@section('content')
<section class="py-16 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                À propos de <span class="text-blue-600">{{ $association->name }}</span>
            </h1>
            <div class="w-24 h-1 bg-blue-400 mx-auto mb-6"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez notre histoire, notre mission et les valeurs qui nous animent
            </p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16 transform transition hover:shadow-2xl">
            @if($association->main_image)
            <div class="relative h-80 overflow-hidden">
                <img src="{{ asset('storage/'.$association->main_image) }}" 
                     alt="Image de l'association"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
            </div>
            @endif
            
            <div class="p-8 md:p-12">
                <div class="prose max-w-none text-gray-600 text-lg">
                    {!! $association->description !!}
                </div>
                
                <!-- Statistiques -->
                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-6 rounded-xl text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $boardMembers->count() }}+</div>
                        <div class="text-gray-600">Membres actifs</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-xl text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">20+</div>
                        <div class="text-gray-600">Événements annuels</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-xl text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">10+</div>
                        <div class="text-gray-600">Projets réalisés</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-xl text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">100%</div>
                        <div class="text-gray-600">Engagement</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notre Bureau -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">
                Notre <span class="text-blue-600">Équipe</span>
            </h2>
            <div class="w-24 h-1 bg-blue-400 mx-auto mb-12"></div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($boardMembers as $member)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 hover:shadow-xl">
                    @if($member->image)
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('storage/'.$member->image) }}" 
                             alt="{{ $member->full_name }}"
                             class="w-full h-full object-cover transition duration-500 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                    @else
                    <div class="h-64 bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-user text-6xl text-gray-400"></i>
                    </div>
                    @endif
                    
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h3>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm font-medium mt-2 mb-3">
                            {{ $member->role }}
                        </span>
                        <p class="text-gray-600 mb-4">{{ $member->bio }}</p>
                        
                        <div class="flex justify-center space-x-3">
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-pink-600 transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Valeurs -->
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                Nos <span class="text-blue-600">Valeurs</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-xl hover:bg-blue-50 transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hands-helping text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Solidarité</h3>
                    <p class="text-gray-600">Nous croyons en la force du collectif et de l'entraide pour construire un avenir meilleur.</p>
                </div>
                
                <div class="text-center p-6 rounded-xl hover:bg-blue-50 transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Engagement</h3>
                    <p class="text-gray-600">Chaque membre s'engage pleinement dans les projets et actions de l'association.</p>
                </div>
                
                <div class="text-center p-6 rounded-xl hover:bg-blue-50 transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Bienveillance</h3>
                    <p class="text-gray-600">Nous accueillons chacun avec respect et dans un esprit d'ouverture et de partage.</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 md:p-12 text-white text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Prêt à nous rejoindre ?</h2>
            <p class="text-lg mb-6 max-w-2xl mx-auto">Que vous souhaitiez devenir membre, bénévole ou simplement en savoir plus, nous serions ravis de vous accueillir.</p>
            <a href="{{ route('contact.create') }}" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition duration-300">
                Contactez-nous <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection