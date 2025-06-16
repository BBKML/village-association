<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('admin-title') | Association du Village</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            @apply bg-gray-50 text-gray-800 antialiased;
        }

        .sidebar-item {
            @apply transition-all duration-200 ease-out;
        }

        .sidebar-item:hover {
            @apply bg-blue-700/10;
        }

        .sidebar-item.active {
            @apply bg-blue-700 text-white;
        }

        .sidebar-item.active .sidebar-icon {
            @apply text-white;
        }

        .sidebar-icon {
            @apply transition-transform duration-150 ease-linear;
        }

        .sidebar-item:hover .sidebar-icon {
            @apply transform translate-x-1;
        }

        .notification-badge {
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .content-card {
            @apply transition-all duration-300 ease-in-out;
        }

        .content-card:hover {
            @apply transform -translate-y-1 shadow-lg;
        }

        .nav-divider {
            @apply border-t border-blue-700/30;
        }

        .main-content {
            height: calc(100vh - 4rem);
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
<div class="flex flex-1">
    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-72 bg-gradient-to-b from-blue-900 to-blue-800 text-white shadow-xl">
<!-- Remplacez tout le bloc logo par ce code -->
<div class="p-5 border-b border-blue-700 flex items-center space-x-3">
    <!-- Conteneur du logo -->
    <div class="bg-white rounded-xl p-1 flex items-center justify-center shadow-sm">
        <img 
            src="{{ asset('assets/images/logo.png') }}" 
            alt="Logo Association du Village"
            class="h-10 w-auto"
            onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-home text-blue-800 text-2xl\'></i>';"
        >
    </div>
    <div>
        <h2 class="text-xl font-bold tracking-tight text-white">Association du Village</h2>
        <p class="text-blue-200 text-xs font-medium">Espace Administrateur</p>
    </div>
</div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <!-- Navigation principale -->
            <div class="mb-8">
                <p class="text-xs uppercase tracking-wider text-blue-300 px-3 mb-3">Navigation</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Tableau de bord</span>
                            @if(request()->routeIs('admin.dashboard'))
                                <span class="ml-auto bg-white rounded-full w-2 h-2"></span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.news.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Actualités</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.activities.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                            <i class="fas fa-running sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Actions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.history.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.history.*') ? 'active' : '' }}">
                            <i class="fas fa-history sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Histoire</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.associations.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.associations.*') ? 'active' : '' }}">
                            <i class="fas fa-users sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Associations</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Gestion -->
            <div class="mb-8">
                <p class="text-xs uppercase tracking-wider text-blue-300 px-3 mb-3">Gestion</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.projects.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                            <i class="fas fa-project-diagram sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Projets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Événements</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.services.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <i class="fas fa-concierge-bell sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Services Locaux</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.galleries.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.galleries.*', 'admin.media.*') ? 'active' : '' }}">
                            <i class="fas fa-images sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Galeries Média</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Utilisateurs -->
            <div class="mb-8">
                <p class="text-xs uppercase tracking-wider text-blue-300 px-3 mb-3">Utilisateurs</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.members.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Membres</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.messages.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Messages</span>
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-badge">{{ $unreadMessages ?? 0 }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuration -->
            <div>
                <p class="text-xs uppercase tracking-wider text-blue-300 px-3 mb-3">Configuration</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="sidebar-item flex items-center p-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog sidebar-icon text-blue-300 mr-3 w-5 text-center"></i>
                            <span class="font-medium">Paramètres</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-blue-700 bg-blue-900/20">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-shield-alt text-blue-300"></i>
                    <span class="text-blue-200 font-medium">Admin</span>
                </div>
                <span class="text-blue-300">v1.2.5</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex justify-between items-center py-3 px-6">
                <!-- Mobile menu button -->
                <button id="menu-toggle" class="lg:hidden text-gray-600 hover:text-gray-900 mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page title -->
                <h1 class="text-xl font-semibold text-gray-800 truncate">
                    @yield('admin-title')
                </h1>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <!-- Search (hidden on mobile) -->
                    <div class="hidden md:block relative">
                        <input type="text" placeholder="Rechercher..." 
                               class="bg-gray-100 rounded-full py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white w-64 transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                    </div>

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center notification-badge">3</span>
                        </button>
                    </div>

                    <!-- User dropdown -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline text-sm font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 hidden md:inline"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50 p-6 overflow-auto">
            @yield('admin-content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-600 mb-3 md:mb-0">
                    <p>&copy; {{ date('Y') }} Association du Village. Tous droits réservés.</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
                        <i class="fas fa-question-circle mr-1"></i> Support
                    </a>
                    <a href="#" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
                        <i class="fas fa-shield-alt mr-1"></i> Confidentialité
                    </a>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Déconnexion
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>


                </div>
            </div>
            <div class="mt-2 text-xs text-gray-400 text-center md:text-left">
                <p>Connecté en tant que <span class="font-medium">{{ Auth::user()->email }}</span> - Dernière activité : {{ Auth::user()->last_login_at?->diffForHumans() ?? 'Jamais' }}</p>
            </div>
        </footer>
    </div>
</div>

<!-- Mobile sidebar overlay -->
<div id="mobile-sidebar" class="fixed inset-0 z-40 lg:hidden hidden">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
    <div class="relative flex flex-col w-80 max-w-xs h-full bg-gradient-to-b from-blue-900 to-blue-800 shadow-xl">
        <!-- Close button -->
        <div class="absolute top-0 right-0 -mr-14 p-1">
            <button id="close-sidebar" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                <i class="fas fa-times text-white text-xl"></i>
            </button>
        </div>
        <!-- Mobile sidebar content would go here -->
    </div>
</div>

<script>
    // Mobile sidebar toggle
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.toggle('hidden');
    });

    document.getElementById('close-sidebar').addEventListener('click', function() {
        document.getElementById('mobile-sidebar').classList.add('hidden');
    });
</script>

@stack('scripts')
</body>
</html>