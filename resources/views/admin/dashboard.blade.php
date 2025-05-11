<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('admin-title', 'Tableau de bord')

@section('admin-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-6">Statistiques</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
        <x-admin-stat-card 
            title="Messages" 
            :value="$stats['messages']" 
            icon="email" 
            color="blue" 
            link="admin.messages.index"
        />
        
        <x-admin-stat-card 
            title="Messages non lus" 
            :value="$stats['unreadMessages']" 
            icon="email-mark-unread" 
            color="red" 
            link="admin.messages.index"
        />
        
        <!-- Ajoutez les autres cartes de stats -->
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Derniers messages</h3>
            <div class="space-y-4">
                @foreach($latestMessages as $message)
                <div class="border-b pb-4">
                    <div class="flex justify-between">
                        <h4 class="font-medium">{{ $message->name }}</h4>
                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $message->message }}</p>
                    <a href="{{ route('admin.messages.show', $message) }}" class="text-blue-600 text-sm hover:underline">Voir le message</a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Projets récents</h3>
            <div class="space-y-4">
                @foreach($latestProjects as $project)
                <div class="border-b pb-4">
                    <h4 class="font-medium">{{ $project->title }}</h4>
                    <div class="flex items-center mt-2">
                        <span class="text-sm {{ $project->status_color }} px-2 py-1 rounded-full">
                            {{ $project->status_label }}
                        </span>
                        <span class="text-sm text-gray-500 ml-2">
                            {{ $project->start_date->format('d/m/Y') }}
                        </span>
                    </div>
                    <a href="{{ route('admin.projects.show', $project) }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">Voir le projet</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection