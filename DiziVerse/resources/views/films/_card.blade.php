<div class="card card--big">
    <a href="{{ route('films.show', $film) }}" class="card__cover">
        <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" />
    </a>
    <button class="card__add" type="button">…</button>
    <span class="card__rating">★ {{ $film->rating }}</span>

    <div class="card__content">
        <h3 class="card__title">
            <a href="{{ route('films.show', $film) }}">{{ $film->title }}</a>
        </h3>
        <ul class="card__list">
            @foreach($film->categories as $kategori)
                <li>{{ $kategori->name }}</li>
            @endforeach
            <li>{{ $film->year }}</li>
        </ul>
        <ul class="card__info">
            <li><span>Yönetmen:</span> <span>{{ $film->director }}</span></li>
        </ul>

        @php
            $desc = $film->description;
            $pos = mb_strpos($desc, '.');
            $firstSentence = $pos !== false ? mb_substr($desc, 0, $pos + 1) : $desc;
            $excerpt = mb_strlen($firstSentence) > 180
                        ? mb_substr($firstSentence, 0, 180) . '...'
                        : $firstSentence;
        @endphp
        <p class="card__tagline">{{ $excerpt }}</p>
    </div>
</div>
