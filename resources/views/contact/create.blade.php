@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-6">Contactez-nous</h1>
        <p class="text-xl">Une question, une suggestion ou envie de nous rejoindre ? Écrivez-nous !</p>
    </div>
</section>

<div class="container py-12">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <h3 class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Nom complet</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                       required>
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-gray-700 font-medium mb-2">Votre message</label>
                <textarea name="message" id="message" rows="6" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror" 
                          required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="captcha" class="block text-gray-700 font-medium mb-2">Vérification CAPTCHA</label>
                <div class="flex items-center space-x-4 mb-3">
                    <div class="captcha-image bg-gray-100 p-2 rounded">
                        {!! captcha_img('flat') !!}
                    </div>
                    <button type="button" onclick="refreshCaptcha()" 
                            class="p-2 text-blue-600 hover:text-blue-800 transition-colors bg-gray-100 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                <input type="text" name="captcha" id="captcha" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('captcha') border-red-500 @enderror" 
                       required placeholder="Entrez le texte ci-dessus">
                @error('captcha')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-lg font-medium text-lg transition-colors">
                    Envoyer le message
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Contact Info -->
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Autres moyens de contact</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-map-marker-alt text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Adresse</h3>
                <p class="text-gray-600">123 Rue de l'Association<br>75000 Ville</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-phone-alt text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Téléphone</h3>
                <p class="text-gray-600">01 23 45 67 89</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-envelope text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Email</h3>
                <p class="text-gray-600">contact@association.org</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function refreshCaptcha() {
        fetch('{{ route("refresh.captcha") }}')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.captcha-image').innerHTML = data.captcha;
            })
            .catch(error => console.error('Error refreshing captcha:', error));
    }
</script>
@endpush
@endsection