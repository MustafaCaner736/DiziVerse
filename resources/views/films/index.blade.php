@extends('layouts.app')

@section('content')
    <style>
        .home__card a {
            position: relative;
            z-index: 2;
            /* kartın linkini öne çıkar */
            display: block;
            /* tüm kart tıklanabilir olsun */
        }

        .home__nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
            /* nav yine linkten daha önde, ama boyut çok küçük */
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.61);
            pointer-events: auto;
            /* sadece buton tıklansın */

        }

        html, body {
        overflow-x: hidden!important; /* sadece dikey scroll kapatılır */
}

        .home__carousel .owl-stage-outer {
            overflow: visible;
            /* kenarlardaki kartların arada clipping yememesine dikkat et */
        }
    </style>
    <!-- Hero Carousel -->
    <div class="home">
        <div class="home__carousel owl-carousel" id="flixtv-hero">
            @foreach ($films as $film)
                <div class="home__card" style="width: 279px!important;">
                    <a href="{{ route('films.show', $film) }}">
                        <img src="{{ $film->poster_url }}" style="height: 350px; width: 279px;" alt="{{ $film->title }}">
                        <div>
                            <h2>{{ $film->title }}</h2>
                            <ul>
                                @foreach ($film->categories as $category)
                                    <li>{{ $category->name }}</li>
                                @endforeach
                                <li>{{ $film->year }}</li>
                            </ul>
                        </div>
                    </a>
                    <span class="home__rating">★ {{ $film->rating }}</span>
                </div>
            @endforeach
        </div>
        <button class="home__nav home__nav--prev" data-nav="#flixtv-hero" type="button"><i class="fas fa-angle-left" style="color: white"></i></button>
        <button class="home__nav home__nav--next" data-nav="#flixtv-hero" type="button"><i class="fas fa-angle-right" style="color: white"></i></button>
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
                        <option value="all" {{ request('genre', 'all') === 'all' ? 'selected' : '' }}>
                            Tüm Kategoriler
                        </option>
                        @foreach($genres as $cat)
                            <option value="{{ $cat->id }}"
                                {{ request('genre') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="slider-radio">
                    <label>
                        <input type="radio" name="grade" value="featured"
                            {{ request('grade', 'newest') === 'featured' ? 'checked' : '' }} />
                        Öne Çıkarılanlar
                    </label>
                    <label>
                        <input type="radio" name="grade" value="newest"
                            {{ request('grade', 'newest') === 'newest' ? 'checked' : '' }} />
                        Yeni
                    </label>
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
document.addEventListener('DOMContentLoaded', () => {
    const genreSelect   = document.getElementById('genre-select');
    const gradeRadios   = document.querySelectorAll('input[name="grade"]');
    const searchInput   = document.getElementById('search-input');
    const searchBtn     = document.getElementById('search-btn');
    const searchClear   = document.getElementById('search-clear');
    let filmsContainer  = document.getElementById('films-container');

    function fetchFilms() {
        const genre  = genreSelect.value;
        const grade  = document.querySelector('input[name="grade"]:checked').value;
        const search = searchInput.value.trim();

        axios.get("{{ route('films.filter') }}", {
            params: { genre, grade, search }
        })
        .then(res => {
            const wrapper = document.createElement('div');
            wrapper.id = 'films-container';
            wrapper.innerHTML = res.data.html;
            filmsContainer.replaceWith(wrapper);
            filmsContainer = wrapper;

            // URL güncelle
            const params = new URLSearchParams({ genre, grade });
            if (search) params.set('search', search);
            window.history.replaceState({}, '', `?${params.toString()}`);
        })
        .catch(console.error);
    }

    // Event’ler
    genreSelect.addEventListener('change', fetchFilms);
    gradeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'featured') {
                genreSelect.value = 'all';
            }
            fetchFilms();
        });
    });
    // Arama
    searchBtn.addEventListener('click', fetchFilms);
    searchInput.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') fetchFilms();
    });
    searchClear.addEventListener('click', () => {
        searchInput.value = '';
        fetchFilms();
    });

    // İlk yüklemede URL parametreleri varsa fetch
    const params = new URLSearchParams(window.location.search);
    if (params.has('genre') || params.has('grade') || params.has('search')) {
        fetchFilms();
    }
});
</script>
@endpush