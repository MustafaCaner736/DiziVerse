<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Film;

class FavoriteController extends Controller
{
    public function toggle(Film $film)
    {
        $user = auth('siteuser')->user();

        if ($user->favoriteFilms()->where('film_id', $film->id)->exists()) {
            $user->favoriteFilms()->detach($film->id);
            $message = 'Favorilerden çıkarıldı.';
        } else {
            $user->favoriteFilms()->attach($film->id);
            $message = 'Favorilere eklendi.';
        }

        return back()->with('success', $message);
    }
}

