<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SiteUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'profile_photo'];
    protected $table = 'site_users';
    protected $hidden = ['password', 'remember_token'];

    public function favoriteFilms()
    {
        return $this->belongsToMany(Film::class, 'favorites');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
