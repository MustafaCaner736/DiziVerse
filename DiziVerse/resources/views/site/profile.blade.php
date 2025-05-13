@extends('layouts.app')

@section('content')
    <h2>Profilim</h2>

    <div>
        <img src="{{ asset('storage/' . auth('siteuser')->user()->avatar) }}" alt="Avatar" width="100">
    </div>

    <p><strong>Ad Soyad:</strong> {{ auth('siteuser')->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth('siteuser')->user()->email }}</p>

    <form method="POST" action="{{ route('siteuser.logout') }}">
        @csrf
        <button type="submit">Çıkış Yap</button>
    </form>
@endsection
