@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Actualités</h1>
    
    <div class="row">
        @foreach($news as $item)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                        <p class="text-muted">
                            <i class="far fa-calendar-alt"></i> 
                            {{ $item->published_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary">Lire l'article</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection