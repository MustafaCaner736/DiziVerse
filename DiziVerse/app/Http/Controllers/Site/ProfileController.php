<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth('siteuser')->user();   // <<< siteuser olarak al
        return view('site.profile', compact('user'));
    }
}
