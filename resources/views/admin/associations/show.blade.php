@extends('layouts.admin')


@section('title', 'Détails de l\'Association')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Détails de l'association: {{ $association->name }}</h6>
            <div>
                <a href="{{ route('admin.associations.edit', $association) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.associations.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($association->main_image)
                        <img src="{{ asset('storage/' . $association->main_image) }}" alt="Image de l'association" class="img-fluid rounded mb-3">
                    @else
                        <div class="alert alert-warning">Aucune image disponible</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $association->name }}</h3>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $association->description }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Objectifs</h5>
                        <p>{{ $association->objectives }}</p>
                    </div>
                    
                    <div class="text-muted">
                        <small>Créée le: {{ $association->created_at->format('d/m/Y H:i') }}</small><br>
                        <small>Dernière modification: {{ $association->updated_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection