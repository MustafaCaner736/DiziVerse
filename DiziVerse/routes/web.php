<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\Site\RegisterController;
use App\Http\Controllers\Site\ProfileController;
use App\Http\Controllers\Site\LoginController;
use App\Http\Controllers\Site\FavoriteController;
use App\Http\Controllers\Site\CommentController;

Route::get('/', [FilmController::class, 'index'])->name('films.index');
Route::get('/film/{film:imdb_id}', [FilmController::class, 'show'])->name('films.show');
// routes/web.php
Route::get('/films/filter', [FilmController::class, 'filter'])->name('films.filter');

Route::middleware('guest:siteuser')->group(function () {
    Route::get('register', [RegisterController::class, 'showForm'])->name('siteuser.register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login',    [LoginController::class, 'showForm'])->name('siteuser.login');
    Route::post('login',   [LoginController::class, 'login']);
});

Route::middleware('auth:siteuser')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('siteuser.profile');
    Route::post('logout',[LoginController::class, 'logout'])->name('siteuser.logout');

    // yorum + favori rotaları
    Route::post('films/{film}/comments', [CommentController::class, 'store'])
         ->name('films.comments.store');

    Route::post('films/{film}/favorite', [FavoriteController::class, 'toggle'])
         ->name('films.favorite.toggle');
});




