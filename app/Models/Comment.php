<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['site_user_id', 'film_id', 'body'];

    public function user()
    {
        return $this->belongsTo(SiteUser::class, 'site_user_id');
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
