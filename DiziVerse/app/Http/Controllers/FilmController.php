<?php

namespace App\Http\Controllers;

use App\Models\Film;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(12);
        return view('films.index', compact('films'));
    }

    public function show(Film $film)
    {
        return view('films.show', compact('film'));
    }
}

