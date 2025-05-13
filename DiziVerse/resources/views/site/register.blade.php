@extends('layouts.app')

@section('content')
    <h2>Kayıt Ol</h2>

    <form method="POST" action="{{ route('siteuser.register') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Ad Soyad</label>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div>
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Şifre Tekrar</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <label>Profil Fotoğrafı</label>
            <input type="file" name="avatar">
        </div>

        <button type="submit">Kayıt Ol</button>
    </form>
@endsection
