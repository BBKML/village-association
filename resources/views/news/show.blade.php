@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <article class="news-article">
                <h1 class="mb-3">{{ $news->title }}</h1>
                
                <div class="meta mb-4">
                    <span class="date">
                        <i class="far fa-calendar-alt"></i> 
                        {{ $news->published_at->format('d/m/Y') }}
                    </span>
                    <span class="author ms-3">
                        <i class="fas fa-user"></i> 
                        {{ $news->author ?? 'Équipe éditoriale' }}
                    </span>
                </div>
                
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid rounded mb-4">
                @endif
                
                <div class="article-content">
                    {!! $news->content !!}
                </div>
                
                <div class="share-buttons mt-5">
                    <h5>Partager cet article :</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="#" class="btn btn-sm btn-outline-info me-2"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="btn btn-sm btn-outline-success me-2"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fas fa-envelope"></i> Email</a>
                </div>
            </article>
        </div>
    </div>
</div>
@endsection