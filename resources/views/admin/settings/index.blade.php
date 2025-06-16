@extends('layouts.admin')

@section('title', 'Paramètres du site')

@section('admin-content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Paramètres du site</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700">Nom du site</label>
                    <input type="text" name="site_name" id="site_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('site_name') border-red-500 @enderror"
                        value="{{ old('site_name', $settings['site_name']->value ?? '') }}">
                    @error('site_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Email de contact</label>
                    <input type="email" name="contact_email" id="contact_email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('contact_email') border-red-500 @enderror"
                        value="{{ old('contact_email', $settings['contact_email']->value ?? '') }}">
                    @error('contact_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700">Téléphone de contact</label>
                    <input type="text" name="contact_phone" id="contact_phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('contact_phone') border-red-500 @enderror"
                        value="{{ old('contact_phone', $settings['contact_phone']->value ?? '') }}">
                    @error('contact_phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo du site</label>
                    <input type="file" name="logo" id="logo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('logo') border-red-500 @enderror"
                        accept="image/*">
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @if(isset($settings['logo']) && $settings['logo']->value)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $settings['logo']->value) }}"
                                alt="Logo actuel"
                                class="h-24 w-auto rounded border border-gray-300 shadow-sm">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <label for="site_description" class="block text-sm font-medium text-gray-700">Description du site</label>
                <textarea name="site_description" id="site_description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('site_description') border-red-500 @enderror">{{ old('site_description', $settings['site_description']->value ?? '') }}</textarea>
                @error('site_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center space-x-4">
                <label for="maintenance_mode" class="text-sm font-medium text-gray-700">Mode maintenance</label>
                <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                       class="h-5 w-5 text-blue-600 border-gray-300 rounded"
                       {{ old('maintenance_mode', $settings['maintenance_mode']->value ?? 0) == 1 ? 'checked' : '' }}>
                <p class="text-sm text-gray-500">Lorsque activé, seuls les administrateurs peuvent accéder au site</p>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i> Enregistrer les paramètres
                </button>
            </div>
        </form>
    </div>
</div>
@endsection