@extends('layouts.app')

@section('content')
    <div class="sign section--full-bg" data-bg="https://flixtv.volkovdesign.com/main/img/bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <!-- authorization form -->
                        <form method="POST" action="{{ route('siteuser.login') }}" class="sign__form">
                            @csrf
                            <a href="index.html" class="sign__logo">
                                <img src="img/logo.svg" alt="">
                            </a>

                            <div class="sign__group">
                                <input type="email" name="email" required class="sign__input" placeholder="Email">
                            </div>

                            <div class="sign__group">
                                <input type="password" name="password" required class="sign__input" placeholder="Şifre">
                            </div>
                            <button type="submit" class="sign__btn">Giriş Yap</button>

                            <span class="sign__text">Hesabın Yok Mu? <a href="{{ route('siteuser.register') }}">Kayıt Ol</a></span>
                        </form>
                        

                        <!-- end authorization form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
