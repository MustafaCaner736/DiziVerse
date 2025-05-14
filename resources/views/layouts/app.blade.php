<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>DiziVerse</title>

    @include ('partials.header')

</head>

<body class="bg-gray-100 text-gray-800">

@if(session('success'))
    <div class="toast-message success" id="toast-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="toast-message error" id="toast-error">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="toast-message error" id="toast-error">
        {{ $errors->first() }}
    </div>
@endif
    @yield('content')

    @include('partials.footer')
    @stack('scripts')
</body>

</html>
