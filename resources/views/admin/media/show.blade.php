@extends('layouts.admin')

@section('admin-content')
    <div class="container">
        <div class="text-center">
            @if($media->file_type === 'image')
                <img src="{{ asset('storage/' . $media->file_path) }}" class="img-fluid" alt="{{ $media->alt_text }}">
            @else
                <video controls class="img-fluid">
                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                </video>
            @endif
            
            <h3>{{ $media->caption }}</h3>
            <p>{{ $media->alt_text }}</p>
            
            <div class="d-flex justify-content-center mt-3">
                @if($prevItem)
                    <a href="{{ route('admin.media.show', $prevItem) }}" class="btn btn-secondary mr-2">Précédent</a>
                @endif
                
                <a href="{{ route('admin.galleries.show', $media->gallery_id) }}" class="btn btn-info mr-2">Retour à la galerie</a>
                
                @if($nextItem)
                    <a href="{{ route('admin.media.show', $nextItem) }}" class="btn btn-secondary">Suivant</a>
                @endif
            </div>
        </div>
    </div>
@endsection