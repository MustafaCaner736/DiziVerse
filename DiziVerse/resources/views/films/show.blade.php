@extends('layouts.app')

@section('content')
    <h1>{{ $film->title }}</h1>
    <img src="{{ $film->poster_url }}" alt="{{ $film->title }}">
    <p><strong>IMDb:</strong> {{ $film->rating }}</p>
    <p><strong>Yıl:</strong> {{ $film->year }}</p>
    <p>{{ $film->description }}</p>

    @php
    $castArray = is_array($film->cast) ? $film->cast : json_decode($film->cast, true);
@endphp

@if(!empty($castArray))
    <p><strong>Oyuncular:</strong></p>
    <ul>
        @foreach($castArray as $actor)
            <li>{{ $actor }}</li>
        @endforeach
    </ul>
@endif


    @if($film->trailer_url)
        <iframe width="560" height="315" src="{{ $film->trailer_url }}" frameborder="0" allowfullscreen></iframe>
    @endif
@endsection
