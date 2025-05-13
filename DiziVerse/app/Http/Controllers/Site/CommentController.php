<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Film $film)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $film->comments()->create([
            'site_user_id' => auth('siteuser')->id(),
            'content'      => $request->input('content'),
        ]);

        return back()->with('success', 'Yorum eklendi.');
    }
}
