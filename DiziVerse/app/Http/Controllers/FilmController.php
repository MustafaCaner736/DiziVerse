<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of films.
     */
    public function index()
    {
        // Ana sayfa için öne çıkan veya tüm filmleri listeler
        $films = Film::with('categories')
                     ->latest()
                     ->paginate(12);

        return view('films.index', compact('films'));
    }

    /**
     * Show a specific film.
     */
    public function show(Film $film)
    {
        return view('films.show', compact('film'));
    }

    /**
     * AJAX ile film filtresi
     */
    public function filter(Request $request)
    {
        $genre = $request->get('genre', 'All genres');
        $grade = $request->get('grade', 'featured');

        $query = Film::with('categories');

        if ($genre !== 'All genres') {
            $query->whereHas('categories', fn($q) => $q->where('name', $genre));
        }

        if ($grade === 'featured') {
            $query->where('featured', true);
        } elseif ($grade === 'newest') {
            $query->orderBy('created_at', 'desc');
        }

        $films = $query->paginate(12);

        // Sadece liste kısmını render edip JSON içinde gönder
        $html = view('films._list', compact('films'))->render();
       return response()->json(['html' => view('films._list', compact('films'))->render()]);

    }
}