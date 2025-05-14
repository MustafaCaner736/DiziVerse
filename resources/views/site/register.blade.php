@extends('layouts.app')

@section('content')

    <div class="sign section--full-bg" data-bg="https://flixtv.volkovdesign.com/main/img/bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">
                        <form method="POST" action="{{ route('siteuser.register') }}" enctype="multipart/form-data" class="sign__form">
                            @csrf
                            <a href="index.html" class="sign__logo">
                                <img src="img/logo.svg" alt="">
                            </a>

                            <div class="sign__group">
                                <input type="text" name="name" required value="{{ old('name') }}" class="sign__input" placeholder="Kullanıcı İsmi">
                            </div>

                            <div class="sign__group">
                                <input type="text" name="email" required value="{{ old('email') }}" class="sign__input" placeholder="Email">
                            </div>

                            <div class="sign__group">
                                <input type="password" name="password" required class="sign__input" placeholder="Şifre">
                            </div>
                            <div class="sign__group">
                                <input type="file" name="profile_photo" class="sign__input">
                            </div>

                            <button class="sign__btn" type="submit">Kayıt Ol</button>

                            <span class="sign__text">Zaten Bir Hesabın Var Mı? <a href="{{ route('siteuser.login') }}">Giriş Yap!</a></span>
                        </form>
                        <!-- registration form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
