<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;               // <<< SiteUser model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

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
            'password' => 'required',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $path = null;
    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('site-user-photos', 'public'); 
        }
        $user = SiteUser::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $path,
        ]);

        // Burada default guard yerine 'siteuser'
        Auth::guard('siteuser')->login($user);

        return redirect()->route('films.index');
    }
}
