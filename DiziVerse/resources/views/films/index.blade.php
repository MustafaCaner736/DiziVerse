@extends('layouts.app')

@section('content')
    <h1>Filmler</h1>
    <div class="grid grid-cols-3 gap-4">
        @foreach($films as $film)
            <div class="border p-4">
                <a href="{{ route('films.show', $film) }}">
                    <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" class="w-full h-auto">
                    <h2 class="text-xl font-bold">{{ $film->title }}</h2>
                    <p>{{ $film->year }} • IMDb: {{ $film->rating }}</p>
                </a>
            </div>
        @endforeach
    </div>
    {{ $films->links() }}
@endsection
