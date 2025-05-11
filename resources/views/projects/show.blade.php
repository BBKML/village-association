@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="project-detail">
                <h1>{{ $project->title }}</h1>
                
                <div class="meta mb-4">
                    <span class="badge 
                        @if($project->status === 'en_cours') bg-warning text-dark
                        @elseif($project->status === 'termine') bg-success
                        @else bg-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                    
                    <span class="date ms-2">
                        <i class="far fa-calendar-alt"></i> 
                        {{ $project->start_date->format('d/m/Y') }} - 
                        {{ $project->end_date ? $project->end_date->format('d/m/Y') : 'À définir' }}
                    </span>
                    
                    @if($project->needs_volunteers)
                        <span class="badge bg-info text-dark float-end">Recherche bénévoles</span>
                    @endif
                    @if($project->needs_donations)
                        <span class="badge bg-danger float-end ms-2">Recherche dons</span>
                    @endif
                </div>
                
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded mb-4">
                
                <div class="description mb-4">
                    {!! $project->description !!}
                </div>
                
                @if($project->gallery && $project->gallery->items->count() > 0)
                    <div class="gallery-section mb-5">
                        <h3>Galerie du projet</h3>
                        <div class="row">
                            @foreach($project->gallery->items as $item)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" data-lightbox="project-gallery" data-title="{{ $item->caption }}">
                                        <img src="{{ asset('storage/' . $item->file_path) }}" class="img-thumbnail" alt="{{ $item->caption }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="project-actions mt-4">
                    @if($project->needs_volunteers)
                        <a href="#" class="btn btn-success">Devenir bénévole</a>
                    @endif
                    @if($project->needs_donations)
                        <a href="#" class="btn btn-danger ms-2">Faire un don</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection