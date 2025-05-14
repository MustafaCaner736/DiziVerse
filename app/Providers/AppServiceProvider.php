<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Livewire\FilmCatalog;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    Livewire::component('film-catalog', FilmCatalog::class);
}
}
