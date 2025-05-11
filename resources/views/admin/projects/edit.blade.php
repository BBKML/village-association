@extends('layouts.admin')

@section('title', 'Modifier le Projet')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Modifier le projet: {{ $project->title }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Titre *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $project->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Date de début *</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Date de fin</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date ? $project->end_date->format('Y-m-d') : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="status">Statut *</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="planned" {{ old('status', $project->status) == 'planned' ? 'selected' : '' }}>Planifié</option>
                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="postponed" {{ old('status', $project->status) == 'postponed' ? 'selected' : '' }}>Reporté</option>
                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Image principale</label>
                    @if($project->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="Image actuelle" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                <label class="form-check-label" for="remove_image">Supprimer l'image actuelle</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF (max: 2MB)</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="needs_volunteers" name="needs_volunteers" {{ old('needs_volunteers', $project->needs_volunteers) ? 'checked' : '' }}>
                    <label class="form-check-label" for="needs_volunteers">
                        Besoin de bénévoles
                    </label>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="needs_donations" name="needs_donations" {{ old('needs_donations', $project->needs_donations) ? 'checked' : '' }}>
                    <label class="form-check-label" for="needs_donations">
                        Besoin de dons
                    </label>
                </div>
                
                <div class="form-group">
                    <label>Galerie d'images</label>
                    @if($project->gallery && $project->gallery->media->count() > 0)
                        <div class="row mb-3">
                            @foreach($project->gallery->media as $media)
                                <div class="col-md-3 mb-2 position-relative">
                                    <img src="{{ asset('storage/' . $media->path) }}" class="img-thumbnail" alt="Image galerie">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                            onclick="if(confirm('Supprimer cette image ?')) { document.getElementById('delete-media-{{ $media->id }}').submit(); }">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-media-{{ $media->id }}" action="{{ route('admin.media.destroy', $media) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('gallery_images.*') is-invalid @enderror" id="gallery_images" name="gallery_images[]" multiple>
                    <small class="form-text text-muted">Vous pouvez sélectionner plusieurs images (max: 2MB par image)</small>
                    @error('gallery_images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection