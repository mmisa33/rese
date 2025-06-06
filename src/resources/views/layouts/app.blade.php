<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    <div class="app">
        {{-- ヘッダー --}}
        <header class="header">

            {{-- メニューアイコン --}}
            <div class="header__menu-toggle" id="menu-toggle">
                <img src="images/icon/menu.png" alt="Menu Icon" class="icon">
            </div>

            {{-- サイトタイトル --}}
            <h1 class="header__title">Rese</h1>

            {{-- ポップアップメニュー --}}
            <div class="header__menu" id="menu">
                <span class="header__menu-close" id="menu-close">&times;</span>
                @auth
                    <a class="header__menu-link" href="{{ route('shops.index') }}">Home</a>
                    <form class="header__menu-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="header__menu-form--logout">Logout</button>
                    </form>
                    <a class="header__menu-link" href="">Mypage</a>
                @else
                    <a class="header__menu-link" href="{{ route('shops.index') }}">Home</a>
                    <a class="header__menu-link" href="{{ route('register') }}">Registration</a>
                    <a class="header__menu-link" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </header>

        {{-- メインコンテンツ --}}
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>

</html>

{{-- メニュー開閉スクリプト --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("menu-toggle");
        const menu = document.getElementById("menu");
        const close = document.getElementById("menu-close");

        toggle.addEventListener("click", function () {
            menu.classList.add("show");
        });

        close.addEventListener("click", function () {
            menu.classList.remove("show");
        });
    });
</script>