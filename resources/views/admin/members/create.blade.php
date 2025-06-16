@extends('layouts.admin')

@section("admin-content")

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Ajouter un Nouveau Membre</h1>

        <form 
            action="{{ route('admin.members.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
        >
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom *</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        id="first_name" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        value="{{ old('first_name') }}"
                    >
                    @error('first_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Nom de Famille *</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        id="last_name" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        value="{{ old('last_name') }}"
                    >
                    @error('last_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <input 
                    type="text" 
                    name="role" 
                    id="role" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                    value="{{ old('role') }}"
                >
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                <textarea 
                    name="bio" 
                    id="bio" 
                    rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                >{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        value="{{ old('phone') }}"
                    >
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label for="joined_date" class="block text-sm font-medium text-gray-700">Date d'adhésion</label>
                    <input 
                        type="date" 
                        name="joined_date" 
                        id="joined_date" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                        value="{{ old('joined_date') }}"
                    >
                    @error('joined_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

               
            </div>

            <div class="mt-4">
                <label for="image" class="block text-sm font-medium text-gray-700">
                    Photo de profil
                </label>
                <div class="mt-1 flex items-center">
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                </div>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_board_member" 
                        id="is_board_member" 
                        value="1"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        {{ old('is_board_member') ? 'checked' : '' }}
                    >
                    <label for="is_board_member" class="ml-2 block text-sm text-gray-900">
                        Membre du Bureau
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a 
                    href="{{ route('admin.members.index') }}" 
                    class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300"
                >
                    Annuler
                </a>
                <button 
                    type="submit" 
                    class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                >
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Add client-side validation or interactivity
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const firstNameInput = document.getElementById('first_name');
        const lastNameInput = document.getElementById('last_name');

        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Basic client-side validation
            if (firstNameInput.value.trim() === '') {
                isValid = false;
                firstNameInput.classList.add('border-red-500');
            } else {
                firstNameInput.classList.remove('border-red-500');
            }

            if (lastNameInput.value.trim() === '') {
                isValid = false;
                lastNameInput.classList.add('border-red-500');
            } else {
                lastNameInput.classList.remove('border-red-500');
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush