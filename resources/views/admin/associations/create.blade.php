@extends('layouts.admin')


@section('title', 'Créer une Association')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Créer une nouvelle association</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.associations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nom de l'association *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="objectives">Objectifs *</label>
                    <textarea class="form-control @error('objectives') is-invalid @enderror" id="objectives" name="objectives" rows="3" required>{{ old('objectives') }}</textarea>
                    @error('objectives')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="main_image">Image principale *</label>
                    <input type="file" class="form-control-file @error('main_image') is-invalid @enderror" id="main_image" name="main_image" required>
                    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF (max: 2MB)</small>
                    @error('main_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Créer l'association</button>
                <a href="{{ route('admin.associations.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection