<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('site.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        
        if (Auth::guard('siteuser')->attempt($credentials)) {
            // Giriş başarılı
            return redirect()->route('films.index');
        }

        return back()->with('error', 'Geçersiz e-posta veya şifre!');
    }

    public function logout()
    {
        Auth::guard('siteuser')->logout();
        return redirect()->route('films.index');
    }
}
