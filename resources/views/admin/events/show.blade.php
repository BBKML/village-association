@extends('layouts.admin')

@section('title', 'Détails de l\'Événement')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Détails de l'événement: {{ $event->title }}</h6>
            <div>
                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement" class="img-fluid rounded mb-3">
                    @else
                        <div class="alert alert-warning">Aucune image principale disponible</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $event->title }}</h3>
                    
                    <div class="mb-3">
                        <h5>Dates</h5>
                        <p>
                            Du <strong>{{ $event->start_date->format('d/m/Y H:i') }}</strong><br>
                            au <strong>{{ $event->end_date->format('d/m/Y H:i') }}</strong>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h5>Lieu</h5>
                        <p>{{ $event->location }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $event->description }}</p>
                    </div>
                </div>
            </div>
            
            @if($event->gallery && $event->gallery->media->count() > 0)
                <hr>
                <h5>Galerie d'images</h5>
                <div class="row">
                    @foreach($event->gallery->media as $media)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $media->path) }}" alt="Image galerie" class="img-thumbnail">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer text-muted">
            <small>Créé le: {{ $event->created_at->format('d/m/Y H:i') }}</small><br>
            <small>Dernière modification: {{ $event->updated_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>
@endsection