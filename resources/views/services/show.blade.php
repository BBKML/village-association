@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="service-detail card shadow-sm">
                <div class="card-body">
                    <!-- En-tête avec titre et catégorie -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="card-title display-5 fw-bold text-primary">{{ $service->name }}</h1>
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-tag me-1"></i> {{ ucfirst($service->type) }}
                        </span>
                    </div>
                    
                    <!-- Image principale avec effet hover -->
                    @if($service->image)
                        <div class="mb-4 overflow-hidden rounded-3" style="max-height: 400px;">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->name }}" 
                                 class="img-fluid w-100 hover-zoom">
                        </div>
                    @endif
                    
                    <!-- Description avec mise en forme enrichie -->
                    <div class="description mb-5 px-3">
                        <div class="border-start border-3 border-primary ps-3">
                            {!! $service->description !!}
                        </div>
                    </div>
                    
                    <!-- Section contact avec icônes modernes -->
                    <div class="contact-info card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Informations de contact
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @if($service->address)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-primary me-3 fs-5"></i>
                                        <span>{{ $service->address }}</span>
                                    </li>
                                @endif
                                @if($service->phone)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-phone text-primary me-3 fs-5"></i>
                                        <a href="tel:{{ $service->phone }}" class="text-decoration-none">
                                            {{ $service->phone }}
                                        </a>
                                    </li>
                                @endif
                                @if($service->email)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-3 fs-5"></i>
                                        <a href="mailto:{{ $service->email }}" class="text-decoration-none">
                                            {{ $service->email }}
                                        </a>
                                    </li>
                                @endif
                                @if($service->website)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-globe text-primary me-3 fs-5"></i>
                                        <a href="{{ $service->website }}" target="_blank" class="text-decoration-none">
                                            {{ parse_url($service->website, PHP_URL_HOST) }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Carte interactive avec style amélioré -->
                    @if($service->map_link)
                        <div class="map mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-map-marked-alt me-2"></i>Localisation
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="{{ $service->map_link }}" 
                                                class="border-0" 
                                                allowfullscreen="" 
                                                loading="lazy"
                                                aria-label="Carte de localisation"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Bouton de retour -->
                    <div class="text-center mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.02);
    }
    .service-detail {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    .description img {
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem;
    }
</style>
@endsection