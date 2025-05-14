<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_user_id',
        'film_id',
    ];

    /**
     * The site user who favorited the film.
     */
    public function user()
    {
        return $this->belongsTo(SiteUser::class, 'site_user_id');
    }

    /**
     * The film that was favorited.
     */
    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
