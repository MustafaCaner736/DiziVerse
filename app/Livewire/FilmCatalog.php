<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Film;
use Livewire\Component;
use Livewire\WithPagination;

class FilmCatalog extends Component
{
    use WithPagination;

    public string $genre = 'all';
    public string $grade = 'featured';

    protected $queryString = [
        'genre' => ['except' => 'all', 'as' => 'kategori'],
        'grade' => ['except' => 'featured', 'as' => 'siralama'],
        'page' => ['except' => 1],
    ];

    public function updating($name, $value): void
    {
        if(in_array($name, ['genre', 'grade'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $films = Film::with('categories')
            ->when($this->genre !== 'all', fn($q) => 
                $q->whereHas('categories', fn($q2) => 
                    $q2->where('id', (int)$this->genre)
                )
            )
            ->when($this->grade === 'featured', fn($q) => $q->where('featured', true))
            ->when($this->grade === 'newest', fn($q) => $q->orderByDesc('created_at'))
            ->paginate(12);

        return view('livewire.film-catalog', [
            'films' => $films,
            'categories' => Category::orderBy('name')->get()
        ]);
    }
}