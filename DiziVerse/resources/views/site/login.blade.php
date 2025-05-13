@extends('layouts.app')

@section('content')
    <h2>Giriş Yap</h2>

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('siteuser.login') }}">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Şifre</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Giriş Yap</button>
    </form>
@endsection
