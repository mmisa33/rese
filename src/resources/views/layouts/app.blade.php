<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common/common.css')}}">
    @yield('css')
</head>

<body>
    <div class="app">
        {{-- ヘッダー --}}
        <header class="header">

            {{-- メニューアイコン --}}
            <div class="header__menu-toggle" id="menu-toggle">
                <img src="{{ asset('images/icon/menu.png') }}" alt="Menu Icon" class="icon">
            </div>

            {{-- サイトタイトル --}}
            <h1 class="header__title">Rese</h1>

            {{-- ポップアップメニュー --}}
            <div class="header__menu" id="menu">
                <span class="header__menu-close" id="menu-close">&times;</span>

                @auth
                @if (Auth::user()->role === 'user')
                    {{-- 一般ユーザー用メニュー --}}
                    <a class="header__menu-link" href="{{ route('shop.index') }}">Home</a>
                    <form class="header__menu-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="header__menu-form--logout">Logout</button>
                    </form>
                    <a class="header__menu-link" href="{{ route('mypage') }}">Mypage</a>

                @elseif (Auth::user()->role === 'admin')
                    {{-- 管理者用メニュー --}}
                    <a class="header__menu-link" href="{{ route('admin.index') }}">Home</a>
                    <form class="header__menu-form" method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="header__menu-form--logout">Logout</button>
                    </form>

                @elseif (Auth::user()->role === 'owner')
                    {{-- 店舗代表者用メニュー --}}
                    <a class="header__menu-link" href="{{ route('owner.index') }}">Home</a>
                    <a class="header__menu-link" href="{{ route('owner.reservation') }}">Reservations</a>
                    <form class="header__menu-form" method="POST" action="{{ route('owner.logout') }}">
                        @csrf
                        <button type="submit" class="header__menu-form--logout">Logout</button>
                    </form>
                @endif

            @else
                {{-- 未ログイン時 --}}
                @if (Request::is('admin/*') || Request::is('owner/*'))
                {{-- 管理者ログイン画面と店舗代表者ログイン画面共通 --}}
                    <a class="header__menu-link" href="{{ route('admin.login') }}">Admin Login</a>
                    <a class="header__menu-link" href="{{ route('owner.login') }}">Owner Login</a>
                @else
                    {{-- 一般ログイン画面 --}}
                    <a class="header__menu-link" href="{{ route('shop.index') }}">Home</a>
                    <a class="header__menu-link" href="{{ route('register') }}">Registration</a>
                    <a class="header__menu-link" href="{{ route('login') }}">Login</a>
                @endif
            @endauth
        </div>

            <div class="link">
                @yield('link')
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