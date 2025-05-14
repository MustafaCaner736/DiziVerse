<div class="card card--big">
    <a href="{{ route('films.show', $film) }}" class="card__cover">
        <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" />
    </a>
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
    $desc         = $film->description;
    $maxLen       = 170;
    $searchLimit  = 175;

    // 1) İlk 180 karakteri al
    $truncated = mb_substr($desc, 0, $maxLen);

    // 2) O parçada en son nokta ve en son virgülün pozisyonunu bul
    $lastDotPos   = mb_strrpos($truncated, '.');
    $lastCommaPos = mb_strrpos($truncated, ',');

    // 3) Hangi işaret daha sonra gelmişse ona göre kes
    if ($lastDotPos !== false || $lastCommaPos !== false) {
        // İkisini karşılaştır, sonuncu pozisyonu bul
        if ($lastDotPos > $lastCommaPos) {
            // Nokta daha sondaysa
            $excerpt = mb_substr($truncated, 0, $lastDotPos + 1);
        } else {
            // Virgül daha sondaysa, virgülü çıkartıp yerine "..."
            $excerpt = mb_substr($truncated, 0, $lastCommaPos) . '...';
        }
    } else {
        // 4) 180 içinde hiç nokta/virgül yoksa 180–195 arası ilk noktayı ara
        $nextDotPos = mb_strpos($desc, '.', $maxLen);
        if ($nextDotPos !== false && $nextDotPos <= $searchLimit) {
            $excerpt = mb_substr($desc, 0, $nextDotPos + 1);
        } else {
            // Hiç nokta/virgül yoksa ya da sınırı aşıyorsa 180 karakter
            $excerpt = $truncated;
        }
    }
@endphp
        <p class="card__tagline">{{ $excerpt }}</p>
    </div>
</div>
