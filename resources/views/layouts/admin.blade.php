<!-- resources/views/layouts/admin.blade.php -->
@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-blue-800 text-white">
        <div class="p-4">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
        </div>
        <nav class="mt-6">
            <x-admin-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-admin-nav-link>
            
            <x-admin-nav-link href="{{ route('admin.associations.index') }}" :active="request()->routeIs('admin.associations.*')">
                Association
            </x-admin-nav-link>
            
            <x-admin-nav-link href="{{ route('admin.histories.index') }}" :active="request()->routeIs('admin.histories.*')">
                Historique
            </x-admin-nav-link>
            
            <!-- Ajoutez les autres liens ici -->
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    @yield('admin-title')
                </h2>
                <div class="flex items-center">
                    <span class="mr-4">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800">Déconnexion</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @yield('admin-content')
        </main>
    </div>
</div>
@endsection