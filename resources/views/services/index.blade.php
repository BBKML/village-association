@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Services Locaux</h1>
    
    <div class="row">
        @foreach($services as $service)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                        <p class="text-muted">
                            <i class="fas fa-tag"></i> {{ ucfirst($service->type) }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-primary">Voir détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $services->links() }}
    </div>
</div>
@endsection