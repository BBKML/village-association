@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Membres du Bureau</h1>
    
    @if($boardMembers->count())
        <div class="row">
            @foreach($boardMembers as $member)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if($member->photo)
                            <img src="{{ asset('storage/'.$member->photo) }}" 
                                 class="card-img-top" 
                                 alt="{{ $member->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $member->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                {{ $member->position->name }}
                            </h6>
                            <p class="card-text">
                                Membre depuis {{ $member->joined_date->format('Y') }}
                            </p>
                            @if($member->description)
                                <p class="card-text">{{ $member->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Aucun membre du bureau n'est enregistré pour le moment.
        </div>
    @endif
</div>
@endsection