<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'СМАРТФОНЫ — учебный интернет-магазин' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">


</head>
<body>

<header class="header">
    <div class="header-inner">

        <h1>
            <a href="{{ route('phones.index') }}">
                СМАРТФОНЫ<br>
                <small>учебный интернет-магазин</small>
            </a>
        </h1>

        <div class="auth-links">
            @auth
                <form method="POST" action="{{ route('logout') }}" >
                    @csrf
                    <button type="submit" class="link-button">Выйти из аккаунта </button>
                </form>
            @else
                <a href="{{ route('login') }}">Вход</a>
                <a href="{{ route('register') }}">Регистрация</a>
            @endauth
                <a href="{{ route('cart.index') }}" class="cart-button">
                    🛒 Корзина
                </a>
        </div>


    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer style="text-align:center; margin-top:50px; color:#666;">
    &copy; {{ date('Y') }} Учебный интернет-магазин
</footer>

</body>
</html>
