@extends('layouts.admin')


@section('title', 'Modifier l\'Association')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Modifier l'association: {{ $association->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.associations.update', $association) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Nom de l'association *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $association->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $association->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="objectives">Objectifs *</label>
                    <textarea class="form-control @error('objectives') is-invalid @enderror" id="objectives" name="objectives" rows="3" required>{{ old('objectives', $association->objectives) }}</textarea>
                    @error('objectives')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="main_image">Image principale</label>
                    @if($association->main_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $association->main_image) }}" alt="Image actuelle" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                <label class="form-check-label" for="remove_image">Supprimer l'image actuelle</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('main_image') is-invalid @enderror" id="main_image" name="main_image">
                    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF (max: 2MB)</small>
                    @error('main_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.associations.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection