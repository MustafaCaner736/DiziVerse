<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;               // <<< SiteUser model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('site.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:site_users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = SiteUser::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // mutator ile hash’lendi
        ]);

        // Burada default guard yerine 'siteuser'
        Auth::guard('siteuser')->login($user);

        return redirect()->route('films.index');
    }
}
