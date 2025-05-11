<!-- resources/views/admin/projects/show.blade.php -->
@extends('layouts.admin')



@section('title', 'Détails du Projet')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Détails du projet: {{ $project->title }}</h6>
            <div>
                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" alt="Image du projet" class="img-fluid rounded mb-3">
                    @else
                        <div class="alert alert-warning">Aucune image principale disponible</div>
                    @endif
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Statut</h5>
                            <span class="badge badge-{{ $project->status_class }}">
                                {{ $project->status_label }}
                            </span>
                            
                            <h5 class="card-title mt-3">Dates</h5>
                            <p class="card-text">
                                Début: {{ $project->start_date->format('d/m/Y') }}<br>
                                @if($project->end_date)
                                    Fin: {{ $project->end_date->format('d/m/Y') }}
                                @else
                                    Fin: Non définie
                                @endif
                            </p>
                            
                            <h5 class="card-title mt-3">Besoins</h5>
                            <p class="card-text">
                                @if($project->needs_volunteers)
                                    <span class="badge badge-info">Bénévoles</span>
                                @endif
                                @if($project->needs_donations)
                                    <span class="badge badge-success">Dons</span>
                                @endif
                                @if(!$project->needs_volunteers && !$project->needs_donations)
                                    <span class="text-muted">Aucun besoin spécifique</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <h3>{{ $project->title }}</h3>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $project->description }}</p>
                    </div>
                    
                    @if($project->gallery && $project->gallery->media->count() > 0)
                        <hr>
                        <h5>Galerie d'images</h5>
                        <div class="row">
                            @foreach($project->gallery->media as $media)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset('storage/' . $media->path) }}" alt="Image galerie" class="img-thumbnail">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <small>Créé le: {{ $project->created_at->format('d/m/Y H:i') }}</small><br>
            <small>Dernière modification: {{ $project->updated_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>
@endsection