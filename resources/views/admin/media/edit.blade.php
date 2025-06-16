@extends('layouts.admin')

@section('admin-content')
    <div class="container my-4">
        <div class="card shadow-lg rounded-4">
            <div class="card-body text-center">
                
                {{-- Aperçu du média --}}
                <div class="mb-4">
                    @if($media->file_type === 'image')
                        <img 
                            src="{{ asset('storage/' . $media->file_path) }}" 
                            class="img-fluid rounded border shadow-sm" 
                            alt="{{ $media->alt_text }}"
                            style="max-height: 500px;"
                        >
                    @else
                        <video 
                            controls 
                            class="img-fluid rounded border shadow-sm" 
                            style="max-height: 500px;"
                        >
                            <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                            Votre navigateur ne prend pas en charge la lecture de vidéos.
                        </video>
                    @endif
                </div>

                {{-- Détails --}}
                <h3 class="fw-bold">{{ $media->caption }}</h3>
                <p class="text-muted fst-italic">{{ $media->alt_text }}</p>

                {{-- Navigation --}}
                <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                    @if($prevItem)
                        <a href="{{ route('admin.media.show', $prevItem) }}" class="btn btn-outline-primary">
                            <i class="bi bi-chevron-left"></i> Précédent
                        </a>
                    @endif

                    <a href="{{ route('admin.galleries.show', $media->gallery_id) }}" class="btn btn-outline-dark">
                        <i class="bi bi-images"></i> Retour à la galerie
                    </a>

                    @if($nextItem)
                        <a href="{{ route('admin.media.show', $nextItem) }}" class="btn btn-outline-primary">
                            Suivant <i class="bi bi-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
