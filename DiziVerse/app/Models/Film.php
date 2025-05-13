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
        'time',
        'poster_url',
        'trailer_url',
        'cast',
        'featured',
        'director',
        
    ];
    protected $casts = [
        'cast' => 'array',
        'featured' => 'boolean',
    ];
    public function getRouteKeyName()
{
    return 'imdb_id';
}
public function categories()
    {

        return $this->belongsToMany(Category::class);
    }

    public function favoritedBy()
{
    return $this->belongsToMany(SiteUser::class, 'favorites');
}

}
