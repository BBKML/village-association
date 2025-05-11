<!-- resources/views/contact/create.blade.php -->
@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Contactez l'association</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 mb-2">Nom</label>
            <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="message" class="block text-gray-700 mb-2">Message</label>
            <textarea name="message" id="message" rows="5" class="w-full px-3 py-2 border rounded-lg" required></textarea>
        </div>

        <div class="mb-4">
            <label for="captcha" class="block text-gray-700 mb-2">Captcha</label>
            <div class="flex items-center">
                <span class="mr-2">{!! captcha_img() !!}</span>
                <button type="button" class="text-blue-600 hover:text-blue-800" onclick="refreshCaptcha()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <input type="text" name="captcha" id="captcha" class="w-full mt-2 px-3 py-2 border rounded-lg" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Envoyer le message
        </button>
    </form>
</div>

@push('scripts')
<script>
    function refreshCaptcha() {
        fetch('/refresh-captcha')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.captcha span').innerHTML = data.captcha;
            });
    }
</script>
@endpush
@endsection