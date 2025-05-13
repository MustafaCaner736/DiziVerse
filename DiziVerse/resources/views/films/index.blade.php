@extends('layouts.app')

@section('content')
    <!-- Hero Carousel -->
    <div class="home">
        <div class="home__carousel owl-carousel" id="flixtv-hero">
            @foreach ($films as $film)
                <div class="home__card" style="width: 279px!important;">
                    <a href="{{ route('films.show', $film) }}">
                        <img src="{{ $film->poster_url }}" style="height: 350px; width: 279px;" alt="{{ $film->title }}">
                    </a>
                    <div>
                        <h2>{{ $film->title }}</h2>
                        <ul>
                            @foreach ($film->categories as $category)
                                <li>{{ $category->name }}</li>
                            @endforeach
                            <li>{{ $film->year }}</li>
                        </ul>
                    </div>
                    <button class="home__add" type="button">…</button>
                    <span class="home__rating">★ {{ $film->rating }}</span>
                </div>
            @endforeach
        </div>
        <button class="home__nav home__nav--prev" data-nav="#flixtv-hero" type="button"></button>
        <button class="home__nav home__nav--next" data-nav="#flixtv-hero" type="button"></button>
    </div>

    <!-- Category Filter + Film List -->
    @php
        use App\Models\Category;
        $categories = Category::orderBy('name')->get();
    @endphp

    <div class="catalog catalog--list">
        <div class="container">
            <div class="catalog__nav">
                <div class="catalog__select-wrap">
                   <select id="genre-select" class="catalog__select">
    <option value="All genres">Tüm Kategoriler</option>
    @foreach ($categories as $cat)
        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
    @endforeach
</select>

                </div>
                <div class="slider-radio">
                   <label><input type="radio" name="grade" value="featured" checked /> Öne Çıkar</label>
<label><input type="radio" name="grade" value="newest" /> Yeni</label>

                </div>
            </div>

            <div id="films-container">
                @include('films._list', ['films' => $films])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const genreSelect = document.getElementById('genre-select');
    const gradeRadios = document.querySelectorAll('input[name="grade"]');
    const filmsContainer = document.getElementById('films-container');

    function fetchFilms() {
        const genre = genreSelect.value;
        const grade = document.querySelector('input[name="grade"]:checked')?.value || 'featured';

        axios.get("{{ route('films.filter') }}", {
            params: { genre, grade }
        })
        .then(response => {
            filmsContainer.outerHTML = response.data.html;
            window.history.replaceState({}, '', `?genre=${encodeURIComponent(genre)}&grade=${grade}`);
        })
        .catch(error => console.error(error));
    }

    // Genre değişince filtrele
    genreSelect.addEventListener('change', fetchFilms);

    // Grade (radio) değişince filtrele
    gradeRadios.forEach(radio => {
        radio.addEventListener('change', fetchFilms);
    });

    // Pagination linkleri AJAX ile çalışsın
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.pagination a');
        if (link) {
            e.preventDefault();
            axios.get(link.href)
                .then(res => {
                    filmsContainer.outerHTML = res.data.html;
                    window.history.pushState({}, '', link.href);
                });
        }
    });
});

    </script>
@endpush