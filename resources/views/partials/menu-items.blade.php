@foreach([
    ['route' => 'home', 'label' => 'Accueil', 'icon' => 'fa-home'],
    ['route' => 'association.about', 'label' => 'Association', 'icon' => 'fa-info-circle'],
    ['route' => 'history.index', 'label' => 'Histoire', 'icon' => 'fa-history'],
    ['route' => 'activities.index', 'label' => 'Activités', 'icon' => 'fa-running'],
    ['route' => 'projects.index', 'label' => 'Projets', 'icon' => 'fa-project-diagram'],
    ['route' => 'news.index', 'label' => 'Actualités', 'icon' => 'fa-newspaper'],
    ['route' => 'events.index', 'label' => 'Événements', 'icon' => 'fa-calendar-alt'],
    ['route' => 'services.index', 'label' => 'Services', 'icon' => 'fa-hands-helping'],
    ['route' => 'contact.create', 'label' => 'Contact', 'icon' => 'fa-envelope']
] as $item)
    @if($type === 'desktop')
        <a href="{{ route($item['route']) }}"
           class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
           aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}">
            <i class="fas {{ $item['icon'] }}" aria-hidden="true"></i>
            {{ $item['label'] }}
        </a>
    @else
        <a href="{{ route($item['route']) }}"
           class="mobile-nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
           aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}">
            <i class="fas {{ $item['icon'] }} text-lg" aria-hidden="true"></i>
            <span class="font-medium">{{ $item['label'] }}</span>
        </a>
    @endif
@endforeach