@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="service-detail">
                <h1>{{ $service->name }}</h1>
                <p class="text-muted mb-4">
                    <i class="fas fa-tag"></i> {{ ucfirst($service->type) }}
                </p>
                
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="img-fluid rounded mb-4">
                @endif
                
                <div class="description mb-4">
                    {!! $service->description !!}
                </div>
                
                <div class="contact-info card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informations de contact</h5>
                        <ul class="list-unstyled">
                            @if($service->address)
                                <li><i class="fas fa-map-marker-alt"></i> {{ $service->address }}</li>
                            @endif
                            @if($service->phone)
                                <li><i class="fas fa-phone"></i> {{ $service->phone }}</li>
                            @endif
                            @if($service->email)
                                <li><i class="fas fa-envelope"></i> <a href="mailto:{{ $service->email }}">{{ $service->email }}</a></li>
                            @endif
                            @if($service->website)
                                <li><i class="fas fa-globe"></i> <a href="{{ $service->website }}" target="_blank">{{ $service->website }}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                @if($service->map_link)
                    <div class="map mb-4">
                        <h5>Localisation</h5>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $service->map_link }}" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection