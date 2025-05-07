<?php

use App\Http\Controllers\FilmController;

Route::get('/', [FilmController::class, 'index'])->name('films.index');
Route::get('/film/{film:imdb_id}', [FilmController::class, 'show'])->name('films.show');
