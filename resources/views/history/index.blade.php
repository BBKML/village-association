@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="text-center mb-5">Notre Histoire</h1>
            
            <div class="history-content mb-5">
                @if($history->image)
                    <img src="{{ asset('storage/' . $history->image) }}" alt="{{ $history->title }}" class="img-fluid rounded mb-4">
                @endif
                <h2>{{ $history->title }}</h2>
                <div class="history-text">
                    {!! $history->content !!}
                </div>
            </div>

            @if($history->founder_name)
                <div class="founder-section bg-light p-4 rounded">
                    <h3>Notre Fondateur</h3>
                    <div class="row align-items-center">
                        @if($history->founder_image)
                            <div class="col-md-3">
                                <img src="{{ asset('storage/' . $history->founder_image) }}" alt="{{ $history->founder_name }}" class="img-fluid rounded-circle">
                            </div>
                        @endif
                        <div class="{{ $history->founder_image ? 'col-md-9' : 'col-12' }}">
                            <h4>{{ $history->founder_name }}</h4>
                            <p>{{ $history->founder_description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection