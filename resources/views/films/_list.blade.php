{{-- resources/views/films/_list.blade.php --}}
<div class="row row--grid">
    @foreach ($films as $film)
        <div class="col-12 col-md-6 col-xl-4">
            @include('films._card', ['film' => $film])
        </div>
    @endforeach
</div>
