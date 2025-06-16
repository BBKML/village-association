<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Tableau de bord - Association du Village')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-6">Statistiques</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Statistiques des actualités --}}
        <div class="bg-blue-50 p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-blue-800 font-semibold">Actualités</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['news'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-newspaper text-blue-600"></i>
                </div>
            </div>
            <a href="{{ route('admin.news.index') }}" class="mt-3 inline-block text-xs text-blue-600 hover:underline">
                Voir toutes les actualités &rarr;
            </a>
        </div>

        {{-- Statistiques des événements --}}
        <div class="bg-green-50 p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-green-800 font-semibold">Événements à venir</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['events'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-green-600"></i>
                </div>
            </div>
            <a href="{{ route('admin.events.index') }}" class="mt-3 inline-block text-xs text-green-600 hover:underline">
                Voir tous les événements &rarr;
            </a>
        </div>

        {{-- Statistiques des projets --}}
        <div class="bg-purple-50 p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-purple-800 font-semibold">Projets actifs</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['projects'] ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-project-diagram text-purple-600"></i>
                </div>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="mt-3 inline-block text-xs text-purple-600 hover:underline">
                Voir tous les projets &rarr;
            </a>
        </div>

        {{-- Statistiques des messages --}}
        <div class="bg-red-50 p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-red-800 font-semibold">Messages non lus</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['unreadMessages'] ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-envelope text-red-600"></i>
                </div>
            </div>
            <a href="{{ route('admin.messages.index') }}" class="mt-3 inline-block text-xs text-red-600 hover:underline">
                Voir tous les messages &rarr;
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Derniers messages -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Derniers messages</h3>
            <div class="space-y-4">
                @forelse($latestMessages as $message)
                <div class="border-b pb-4">
                    <div class="flex justify-between">
                        <h4 class="font-medium">{{ $message->name }}</h4>
                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $message->message }}</p>
                    <a href="{{ route('admin.messages.show', $message) }}" class="text-blue-600 text-sm hover:underline">Voir le message</a>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <p>Aucun message récent</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Activités récentes -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Activités récentes</h3>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="border-b pb-4">
                    <div class="flex items-start">
                        <div class="mr-4 text-{{ $activity['color'] }}-500">
                            <i class="fas fa-{{ $activity['icon'] }}"></i>
                        </div>
                        <div>
                            <h4 class="font-medium">{{ $activity['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                            <span class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <p>Aucune activité récente</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <a href="{{ route('admin.news.create') }}" class="bg-white shadow rounded-lg p-4 text-center hover:shadow-md transition-shadow content-card">
                <div class="text-blue-500 mb-2">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium">Ajouter une actualité</span>
            </a>
            
            <a href="{{ route('admin.events.create') }}" class="bg-white shadow rounded-lg p-4 text-center hover:shadow-md transition-shadow content-card">
                <div class="text-green-500 mb-2">
                    <i class="fas fa-calendar-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium">Créer un événement</span>
            </a>
            
            <a href="{{ route('admin.projects.create') }}" class="bg-white shadow rounded-lg p-4 text-center hover:shadow-md transition-shadow content-card">
                <div class="text-purple-500 mb-2">
                    <i class="fas fa-project-diagram text-xl"></i>
                </div>
                <span class="text-sm font-medium">Lancer un projet</span>
            </a>
            
            <a href="{{ route('admin.members.create') }}" class="bg-white shadow rounded-lg p-4 text-center hover:shadow-md transition-shadow content-card">
                <div class="text-yellow-500 mb-2">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium">Ajouter un membre</span>
            </a>
            
            <a href="{{ route('admin.galleries.create') }}" class="bg-white shadow rounded-lg p-4 text-center hover:shadow-md transition-shadow content-card">
                <div class="text-red-500 mb-2">
                    <i class="fas fa-image text-xl"></i>
                </div>
                <span class="text-sm font-medium">Ajouter des photos</span>
            </a>
                
        </div>
    </div>
</div>
@endsection