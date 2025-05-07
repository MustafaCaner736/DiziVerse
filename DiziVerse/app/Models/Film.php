<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'imdb_id',
        'title',
        'description',
        'rating',
        'year',
        'poster_url',
        'trailer_url',
        'cast',
    ];
    protected $casts = [
        'cast' => 'array',
    ];
    public function getRouteKeyName()
{
    return 'imdb_id';
}

}
