@extends('layouts.admin')


@section('title', 'Détails de l\'Activité')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Détails de l'Activité</h6>
            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $activity->title }}</h3>
                    <p><strong>Date :</strong> {{ $activity->date->format('d/m/Y') }}</p>
                    <p><strong>Lieu :</strong> {{ $activity->location }}</p>
                    <p><strong>Description :</strong></p>
                    <p>{{ $activity->description }}</p>
                </div>
                <div class="col-md-4">
                    @if($activity->image)
                        <img src="{{ asset('storage/' . $activity->image) }}" alt="Image de l'activité" class="img-fluid rounded">
                    @else
                        <div class="text-muted">Aucune image disponible</div>
                    @endif
                </div>
            </div>
            
            @if($activity->gallery)
                <hr>
                <h5>Galerie associée</h5>
                <div class="row">
                    @foreach($activity->gallery->media as $media)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $media->path) }}" alt="Media" class="img-thumbnail">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
        </div>
    </div>
@endsection