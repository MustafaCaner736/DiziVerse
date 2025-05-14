@extends('layouts.app')

@section('content')
    {{-- <h1>{{ $film->title }}</h1>
    <img src="{{ $film->poster_url }}" alt="{{ $film->title }}">
    <p><strong>IMDb:</strong> {{ $film->rating }}</p>
    <p><strong>Yıl:</strong> {{ $film->year }}</p>
    <p>{{ $film->description }}</p>

    @php
    $castArray = is_array($film->cast) ? $film->cast : json_decode($film->cast, true);
@endphp

@if (!empty($castArray))
    <p><strong>Oyuncular:</strong></p>
    <ul>
        @foreach ($castArray as $actor)
            <li>{{ $actor }}</li>
        @endforeach
    </ul>
@endif


    @if ($film->trailer_url)
        <iframe width="560" height="315" src="{{ $film->trailer_url }}" frameborder="0" allowfullscreen></iframe>
    @endif --}}

    <section class="section section--head section--head-fixed section--gradient section--details-bg">
        <div class="section__bg" data-bg="{{ $film->poster_url }}"></div>
        <div class="container">
            <!-- article -->
            <div class="article">
                <div class="row">
                    <div class="col-12 col-xl-8">

                        <!-- article content -->
                        <div class="article__content">
                            <h1>{{ $film->title }}</h1>

                            <ul class="list">
                                <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path
                                            d="M22,9.67A1,1,0,0,0,21.14,9l-5.69-.83L12.9,3a1,1,0,0,0-1.8,0L8.55,8.16,2.86,9a1,1,0,0,0-.81.68,1,1,0,0,0,.25,1l4.13,4-1,5.68A1,1,0,0,0,6.9,21.44L12,18.77l5.1,2.67a.93.93,0,0,0,.46.12,1,1,0,0,0,.59-.19,1,1,0,0,0,.4-1l-1-5.68,4.13-4A1,1,0,0,0,22,9.67Zm-6.15,4a1,1,0,0,0-.29.88l.72,4.2-3.76-2a1.06,1.06,0,0,0-.94,0l-3.76,2,.72-4.2a1,1,0,0,0-.29-.88l-3-3,4.21-.61a1,1,0,0,0,.76-.55L12,5.7l1.88,3.82a1,1,0,0,0,.76.55l4.21.61Z" />
                                    </svg> {{ $film->rating }}</li>

                                <li>{{ $film->categories[0]->name }}</li>

                                <li>{{ $film->year }}</li>
                                <li>{{ $film->time }}</li>

                            </ul>

                            @auth('siteuser')
                                {{-- Favori butonu --}}
                                <form action="{{ route('films.favorite.toggle', $film) }}" method="POST">
                                    @csrf
                                    <div class="article__btns">
                                        <button type="submit" class="article__btn article__btn--white">
                                            {{ auth('siteuser')->user()->favoriteFilms->contains($film->id) ? 'Favoriden Çıkar' : 'Favoriye Ekle' }}
                                        </button>
                                    </div>
                                </form>
                            @endauth


                            <p>{{ $film->description }}</p>
                        </div>
                        <!-- end article content -->
                    </div>

                    <div class="col-12 col-xl-8">
                        <!-- categories -->
                        <div class="categories">
                            <h3 class="categories__title">Kategoriler</h3>
                            @foreach ($film->categories as $cat)
                                <a class="categories__item">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                        <!-- end categories -->

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-8">
                        <!-- comments and reviews -->
                        <div class="comments">
                            <!-- tabs nav -->
                            <ul class="nav nav-tabs comments__title comments__title--tabs" id="comments__tabs"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab"
                                        aria-controls="tab-1" aria-selected="true">
                                        <h4>Yorumlar</h4>

                                        <span>{{ count($film->comments) }}</span>
                                    </a>
                                </li>

                            </ul>
                            <!-- end tabs nav -->

                            <!-- tabs -->
                            <div class="tab-content">
                                <!-- comments -->
                                <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                                    <ul class="comments__list">
                                        @if (isset($film->comments))
                                            @foreach ($film->comments as $comment)
                                                <li style="margin-bottom: 20px;">
                                                    <div class="comments__autor">
                                                        @if (isset($comment->user->profile_photo))
                                                            <img class="comments__avatar"
                                                                src="/storage/{{ $comment->user->profile_photo }}"
                                                                alt="">
                                                        @endif
                                                        <span class="comments__name">{{ $comment->user->name }}</span>
                                                        <span
                                                            class="comments__time">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="comments__text">{{ $comment->body }}</p>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>

                                    @auth('siteuser')
                                        {{-- Yorum formu --}}
                                        <form action="{{ route('films.comments.store', $film) }}" method="POST">
                                            @csrf
                                            <div class="sign__group">
                                                <textarea id="text" name="body" required class="sign__textarea" placeholder="Yorum Ekle"></textarea>
                                            </div>
                                            <button class="sign__btn" type="submit">Gönder</button>
                                        </form>
                                    @endauth

                                </div>
                                <!-- end comments -->


                            </div>
                            <!-- end tabs -->
                        </div>
                        <!-- end comments and reviews -->
                    </div>

                    <div class="col-12 col-xl-4">
                        <div class="sidebar sidebar--mt">
                            <!-- end subscribe -->

                            <!-- new items -->
                            <div class="row row--grid">
                                <div class="col-12">
                                    <h5 class="sidebar__title">En Yeni Öne Çıkanlar</h5>
                                </div>
                                @if(isset($featuredFilms))

                                @foreach ($featuredFilms as $ffilm)
                                    <div class="col-6 col-sm-4 col-md-3 col-xl-6">
                                        <div class="card">
                                            <a href="{{ route('films.show', $ffilm) }}" class="card__cover">
                                                <img src="{{ $ffilm->poster_url }}" alt="{{ $ffilm->title }}">
                                                <!-- Play ikonunu olduğu gibi bırakabilirsiniz -->
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <!-- SVG path’leri… -->
                                                </svg>
                                            </a>
                                            <span class="card__rating">
                                                <!-- Yıldız ikonu SVG --> {{ $ffilm->rating }}
                                            </span>
                                            <h3 class="card__title">
                                                <a href="{{ route('films.show', $ffilm) }}">{{ $ffilm->title }}</a>
                                            </h3>
                                            <ul class="card__list">
                                                <li>{{ $ffilm->price_label ?? 'Free' }}</li>
                                                @foreach ($ffilm->categories as $cat)
                                                    <li>{{ $cat->name }}</li>
                                                @endforeach
                                                <li>{{ $ffilm->year }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            <!-- end new items -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- end article -->
        </div>
    </section>
@endsection
