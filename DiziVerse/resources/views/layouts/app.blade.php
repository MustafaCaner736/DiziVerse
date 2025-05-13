<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>DiziVerse</title>
    
    @include ('partials.header')
    
</head>
<body class="bg-gray-100 text-gray-800">
     <nav>
        @auth('siteuser')
            <a href="{{ route('siteuser.profile') }}">Profil</a>
            <form method="POST" action="{{ route('siteuser.logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Çıkış</button>
            </form>
        @else
            <a href="{{ route('siteuser.login') }}">Giriş</a>
            <a href="{{ route('siteuser.register') }}">Kayıt</a>
        @endauth
    </nav>

    <hr>
    
        @yield('content')
   
    @include('partials.footer')
       @stack('scripts')
</body>
</html>
