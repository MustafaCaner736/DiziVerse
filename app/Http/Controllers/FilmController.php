<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Category;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $genres = Category::orderBy('name')->get();

        $genre = $request->input('genre', 'all');
        $grade = $request->input('grade', 'newest');
        $search = $request->input('search', '');

        $films = Film::with('categories')
            // Kategori filtresi
            ->when(
                $genre !== 'all',
                fn($q) =>
                $q->whereHas(
                    'categories',
                    fn($q2) =>
                    $q2->where('id', $genre)
                )
            )
            // Arama filtresi
            ->when(
                $search !== '',
                fn($q) =>
                $q->where('title', 'LIKE', "%{$search}%")
            )
            // Grade filtresi / sıralaması
            ->when(
                $grade === 'featured',
                fn($q) =>
                $q->where('featured', true)
            )
            ->when(
                $grade === 'newest',
                fn($q) =>
                $q->orderByDesc('year')
            )
            ->get();
             

        return view('films.index', compact('films', 'genres'));
    }

    public function show(Film $film)
    {
        $featuredFilms = Film::with('categories')
        ->where('featured', true)
        // Şu anki filmin tekrarını önlemek için:
        ->where('id', '!=', $film->id)
        ->orderByDesc('year')
        ->limit(4)
        ->get();

        return view('films.show', compact('film', 'featuredFilms'));
    }

    public function filter(Request $request)
    {
        $genre = $request->input('genre', 'all');
        $grade = $request->input('grade', 'newest');
        $search = $request->input('search', '');

        $query = Film::with('categories')
            ->when(
                $genre !== 'all',
                fn($q) =>
                $q->whereHas(
                    'categories',
                    fn($q2) =>
                    $q2->where('id', $genre)
                )
            )
            ->when(
                $search !== '',
                fn($q) =>
                $q->where('title', 'LIKE', "%{$search}%")
            )
            ->when(
                $grade === 'featured',
                fn($q) =>
                $q->where('featured', true)
            )
            ->when(
                $grade === 'newest',
                fn($q) =>
                $q->orderByDesc('year')
            );

        $films = $query->get();

        return response()->json([
            'html' => view('films._list', compact('films'))->render(),
        ]);
    }
}
