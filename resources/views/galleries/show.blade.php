@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $gallery->title }}</h1>
        <a href="{{ route('galleries.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
    
    <div class="mb-4">
        <p class="lead">{{ $gallery->description }}</p>
        <div class="d-flex gap-2">
            <span class="badge bg-{{ $gallery->type === 'activity' ? 'info' : ($gallery->type === 'project' ? 'success' : 'warning') }}">
                {{ ucfirst($gallery->type) }}
            </span>
            <span class="text-muted">
                {{ $gallery->items_count }} éléments
            </span>
        </div>
    </div>
    
    @if($gallery->items->isEmpty())
        <div class="alert alert-info text-center">
            Cette galerie ne contient aucun élément pour le moment.
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($gallery->items as $item)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($item->file_type === 'image')
                        <img src="{{ asset('storage/' . $item->file_path) }}" 
                             class="card-img-top" 
                             alt="{{ $item->alt_text ?? $item->caption }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-video fa-3x"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->caption }}</h6>
                        @if($item->alt_text)
                            <p class="card-text small text-muted">{{ $item->alt_text }}</p>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ asset('storage/' . $item->file_path) }}" 
                           class="btn btn-sm btn-outline-primary w-100"
                           target="_blank"
                           download="{{ Str::slug($item->caption) }}-{{ $item->id }}">
                            <i class="fas fa-download"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection