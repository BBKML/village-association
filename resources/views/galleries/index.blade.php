@extends('layouts.app') {{-- Utilisez votre layout public --}}

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Galerie Médiatique</h1>

    @if($galleries->isEmpty())
        <div class="alert alert-info text-center">
            Aucune galerie disponible pour le moment.
        </div>
    @else
        <div class="row">
            @foreach($galleries as $gallery)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($gallery->items->first())
                        @if($gallery->items->first()->file_type === 'image')
                            <img src="{{ asset('storage/' . $gallery->items->first()->file_path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $gallery->items->first()->caption }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-dark text-white d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-video fa-3x"></i>
                            </div>
                        @endif
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-images fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $gallery->title }}</h5>
                        <p class="card-text text-muted small">
                            {{ $gallery->description ? Str::limit($gallery->description, 100) : 'Aucune description' }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $gallery->type === 'activity' ? 'info' : ($gallery->type === 'project' ? 'success' : 'warning') }}">
                                {{ ucfirst($gallery->type) }}
                            </span>
                            <span class="text-muted small">
                                {{ $gallery->items_count }} éléments
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('galleries.show', $gallery) }}" 
                           class="btn btn-sm btn-outline-primary w-100">
                            Voir la galerie
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>
@endsection