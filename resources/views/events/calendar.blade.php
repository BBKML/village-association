@extends('layouts.app')

@section('title', 'Calendrier des Événements - ' . ($association->name ?? 'Association'))

@section('hero-section')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white py-24 md:py-32 overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1517502884422-41eaead166d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fadeInUp" style="animation-delay: 0.1s">
            Calendrier <span class="text-yellow-300">des Événements</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto animate-fadeInUp" style="animation-delay: 0.3s">
            Découvrez tous nos événements à venir en un coup d'œil
        </p>
    </div>
</section>
@endsection

@section('content')
<div class="container mx-auto px-4 py-16">
    <!-- Calendar Navigation -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                Agenda Complet
            </h2>
            <p class="text-gray-600">Explorez nos événements par mois, semaine ou jour</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('events.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition">
               <i class="fas fa-list mr-2"></i> Vue Liste
            </a>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <div id="calendar" class="p-4"></div>
    </div>

    <!-- Legend -->
    <div class="mt-8 flex flex-wrap gap-4 justify-center">
        <div class="flex items-center">
            <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
            <span class="text-sm text-gray-700">Événements culturels</span>
        </div>
        <div class="flex items-center">
            <span class="w-4 h-4 bg-green-500 rounded-full mr-2"></span>
            <span class="text-sm text-gray-700">Activités sportives</span>
        </div>
        <div class="flex items-center">
            <span class="w-4 h-4 bg-purple-500 rounded-full mr-2"></span>
            <span class="text-sm text-gray-700">Ateliers éducatifs</span>
        </div>
        <div class="flex items-center">
            <span class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></span>
            <span class="text-sm text-gray-700">Rencontres sociales</span>
        </div>
    </div>
</div>

<!-- Upcoming Highlights -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Événements à ne pas manquer</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-8"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($highlightedEvents))
            @foreach($highlightedEvents as $event)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="relative h-48 overflow-hidden">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" 
                             alt="{{ $event->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center">
                            <i class="fas fa-calendar-day text-4xl text-white opacity-80"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->title }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="far fa-calendar-alt mr-2 text-blue-500"></i>
                        <span>{{ $event->start_date->translatedFormat('d F Y') }}</span>
                    </div>
                    <a href="{{ route('events.show', $event) }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                       Voir détails <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5/locales/fr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($formattedEvents),
            eventClick: function(info) {
                window.location.href = info.event.url;
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            locale: 'fr',
            firstDay: 1, // Lundi comme premier jour de la semaine
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour',
                list: 'Liste'
            },
            eventDisplay: 'block',
            eventColor: function(info) {
                // Retourne une couleur différente selon la catégorie
                const category = info.event.extendedProps.category;
                switch(category) {
                    case 'culturel': return '#3B82F6'; // blue-500
                    case 'sportif': return '#10B981'; // green-500
                    case 'educatif': return '#8B5CF6'; // purple-500
                    case 'social': return '#F59E0B'; // yellow-500
                    default: return '#6366F1'; // indigo-500
                }
            },
            eventContent: function(arg) {
                // Custom event display
                const titleEl = document.createElement('div');
                titleEl.classList.add('fc-event-title');
                titleEl.innerHTML = `<i class="fas ${getEventIcon(arg.event.extendedProps.category)} mr-1"></i> ${arg.event.title}`;
                
                const timeEl = document.createElement('div');
                timeEl.classList.add('fc-event-time');
                timeEl.innerText = arg.timeText;
                
                const container = document.createElement('div');
                container.appendChild(timeEl);
                container.appendChild(titleEl);
                
                return { domNodes: [container] };
            },
            eventDidMount: function(info) {
                // Tooltip for events
                if (info.event.extendedProps.description) {
                    new bootstrap.Tooltip(info.el, {
                        title: info.event.extendedProps.description,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            }
        });
        calendar.render();
        
        function getEventIcon(category) {
            switch(category) {
                case 'culturel': return 'fa-music';
                case 'sportif': return 'fa-running';
                case 'educatif': return 'fa-graduation-cap';
                case 'social': return 'fa-users';
                default: return 'fa-calendar-day';
            }
        }
    });
</script>

<!-- Include Bootstrap JS for tooltips -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Custom FullCalendar styles */
    .fc {
        font-family: 'Nunito', sans-serif;
    }
    
    .fc-toolbar-title {
        font-weight: 700;
        color: #1E3A8A;
    }
    
    .fc-button {
        background-color: #EFF6FF !important;
        color: #1E40AF !important;
        border: 1px solid #DBEAFE !important;
        font-weight: 500 !important;
        text-transform: capitalize !important;
    }
    
    .fc-button:hover {
        background-color: #DBEAFE !important;
    }
    
    .fc-button-active {
        background-color: #3B82F6 !important;
        color: white !important;
    }
    
    .fc-daygrid-day-number {
        color: #1F2937;
        font-weight: 500;
    }
    
    .fc-daygrid-day.fc-day-today {
        background-color: #EFF6FF;
    }
    
    .fc-event {
        border-radius: 6px !important;
        border: none !important;
        padding: 4px 6px !important;
        margin-bottom: 4px !important;
    }
    
    .fc-event-title {
        font-weight: 500;
        white-space: normal !important;
    }
    
    .fc-event-time {
        font-size: 0.8em;
        opacity: 0.8;
        margin-bottom: 2px;
    }
</style>
@endsection