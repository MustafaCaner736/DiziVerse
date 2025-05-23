<!-- CSS -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

<link rel="stylesheet" href="{{ asset('front/css/bootstrap-reboot.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/bootstrap-grid.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/slider-radio.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/plyr.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
<style>
    .toast-message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        z-index: 9999;
        color: #fff;
        font-weight: 500;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .toast-message.success {
        background-color: #28a745;
    }

    .toast-message.error {
        background-color: #dc3545;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<!-- Favicons -->
<link rel="icon" type="image/png" href="{{ asset('front/icon/fav.png') }}" sizes="32x32">
<link rel="apple-touch-icon" href="{{ asset('front/icon/fav.png') }}">

<header class="header header--static">
    <div class="container">
        <div class="row" style="justify-content: center">
            <div class="col-6">
                <div class="header__content">
                    <button class="header__menu" type="button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <a href="/" class="header__logo">
                        <img src="{{ asset('front/icon/dv.png') }}"
                            alt="Movies & TV Shows, Online cinema HTML Template">
                    </a>

                    <div class="header__actions">

                        <form id="film-search-form" class="header__form" onsubmit="return false;">
                            <input id="search-input" name="search" class="header__form-input" type="text"
                                placeholder="Film Arama..." value="{{ request('search', '') }}">
                            <button id="search-btn" class="header__form-btn" type="button"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z" />
                                </svg></button>
                            <button id="search-clear" type="button" class="header__form-close"><svg width="20"
                                    height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M14.3345 0.000183105H5.66549C2.26791 0.000183105 0.000488281 2.43278 0.000488281 5.91618V14.0842C0.000488281 17.5709 2.26186 20.0002 5.66549 20.0002H14.3335C17.7381 20.0002 20.0005 17.5709 20.0005 14.0842V5.91618C20.0005 2.42969 17.7383 0.000183105 14.3345 0.000183105ZM5.66549 1.50018H14.3345C16.885 1.50018 18.5005 3.23515 18.5005 5.91618V14.0842C18.5005 16.7653 16.8849 18.5002 14.3335 18.5002H5.66549C3.11525 18.5002 1.50049 16.7655 1.50049 14.0842V5.91618C1.50049 3.23856 3.12083 1.50018 5.66549 1.50018ZM7.07071 7.0624C7.33701 6.79616 7.75367 6.772 8.04726 6.98988L8.13137 7.06251L9.99909 8.93062L11.8652 7.06455C12.1581 6.77166 12.6329 6.77166 12.9258 7.06455C13.1921 7.33082 13.2163 7.74748 12.9984 8.04109L12.9258 8.12521L11.0596 9.99139L12.9274 11.8595C13.2202 12.1524 13.2202 12.6273 12.9273 12.9202C12.661 13.1864 12.2443 13.2106 11.9507 12.9927L11.8666 12.9201L9.99898 11.052L8.13382 12.9172C7.84093 13.2101 7.36605 13.2101 7.07316 12.9172C6.80689 12.6509 6.78269 12.2343 7.00054 11.9407L7.07316 11.8566L8.93843 9.99128L7.0706 8.12306C6.77774 7.83013 6.77779 7.35526 7.07071 7.0624Z" />
                                </svg></button>
                        </form>

                        <button class="header__search" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z" />
                            </svg>
                        </button>
                        @auth('siteuser')
                            <a class="header__user" href="{{ route('siteuser.profile') }}">
                                <span style="margin-right: 15px">{{ auth('siteuser')->user()->name }}</span>

                                <div class="profile__avatar">
                                    @if (isset(auth('siteuser')->user()->profile_photo))
                                        <img src="/storage/{{ auth('siteuser')->user()->profile_photo }}" alt="">
                                    @else
                                        <img src="{{ asset('front/icon/pp.png') }}" alt="">
                                    @endif
                                </div>

                            </a>
                        @else
                            <a href="{{ route('siteuser.login') }}" class="header__user">
                                <span>Giriş Yap</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M20,12a1,1,0,0,0-1-1H11.41l2.3-2.29a1,1,0,1,0-1.42-1.42l-4,4a1,1,0,0,0-.21.33,1,1,0,0,0,0,.76,1,1,0,0,0,.21.33l4,4a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42L11.41,13H19A1,1,0,0,0,20,12ZM17,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V16a1,1,0,0,0-2,0v3a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4H17a1,1,0,0,1,1,1V8a1,1,0,0,0,2,0V5A3,3,0,0,0,17,2Z" />
                                </svg>
                            </a>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end header -->
