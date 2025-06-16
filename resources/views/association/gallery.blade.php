@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Galerie de l'association</h1>
        <p class="lead">Découvrez nos moments forts en images et vidéos</p>
    </div>
    
    @if($association->mediaGallery && $association->mediaGallery->mediaItems->count())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($association->mediaGallery->mediaItems as $media)
                <div class="col">
                    <div class="card h-100 shadow-sm gallery-item">
                        @if($media->type === 'image')
                            <a href="{{ asset('storage/'.$media->path) }}" data-lightbox="gallery" data-title="{{ $media->caption }}">
                                <img src="{{ asset('storage/'.$media->path) }}" 
                                     alt="{{ $media->alt_text }}" 
                                     class="card-img-top img-fluid"
                                     style="height: 200px; object-fit: cover;">
                            </a>
                        @else
                            <div class="ratio ratio-16by9">
                                <iframe src="{{ $media->embed_url }}" 
                                        class="card-img-top"
                                        allowfullscreen></iframe>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            @if($media->caption)
                                <h5 class="card-title">{{ $media->caption }}</h5>
                            @endif
                            @if($media->alt_text)
                                <p class="card-text small text-muted">{{ $media->alt_text }}</p>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            @if($media->type === 'image')
                                <a href="{{ asset('storage/'.$media->path) }}" 
                                   class="btn btn-sm btn-outline-primary"
                                   download="association-{{ $media->id }}-{{ Str::slug($media->caption) }}">
                                    <i class="fas fa-download me-1"></i>Télécharger
                                </a>
                            @else
                                <a href="{{ $media->embed_url }}" 
                                   class="btn btn-sm btn-outline-primary"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>Voir
                                </a>
                            @endif
                            <span class="badge bg-secondary align-self-center">
                                {{ $media->type === 'image' ? 'Image' : 'Vidéo' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination si nécessaire -->
        @if($association->mediaGallery->mediaItems->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $association->mediaGallery->mediaItems->links() }}
            </div>
        @endif
    @else
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-images fa-3x mb-3 text-muted"></i>
            <h4>Aucun média disponible pour le moment</h4>
            <p class="mb-0">Notre galerie sera bientôt mise à jour avec de nouveaux contenus.</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .gallery-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-img-top {
        border-radius: 0.375rem 0.375rem 0 0;
    }
</style>
@endpush

@push('scripts')
<!-- Lightbox pour les images -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Image %1 sur %2"
    });
</script>
@endpush