<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth('siteuser')->user();   // <<< siteuser olarak al
        return view('site.profile', compact('user'));
    }
     public function updatePassword(Request $request)
    {
        $user = auth('siteuser')->user();

        $request->validate([
            'oldpass'      => 'required',
            'newpass'      => 'required',
            'confirmpass'  => 'required|same:newpass',
        ]);

        if (!Hash::check($request->oldpass, $user->password)) {
            return back()->withErrors(['oldpass' => 'Eski şifre hatalı.']);
        }

        $user->password = bcrypt($request->newpass);
        $user->save();

        return back()->with('success', 'Şifreniz başarıyla güncellendi.');
    }
    public function updateInfo(Request $request)
{
    $user = auth('siteuser')->user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:site_users,email,' . $user->id,
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    $path = null;
if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('site-user-photos', 'public'); 
        }
    $user->name  = $request->name;
    $user->email = $request->email;
    if($path!=null)
        $user->profile_photo  = $path;
    $user->save();

    return back()->with('success', 'Profil bilgileri güncellendi.');
}

}
