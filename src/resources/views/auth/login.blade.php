@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<div class="login-form">

    {{-- ログインフォーム --}}
    <div class="login-form__inner">

        <div class="login-form__header">Login</div>

        <form class="login-form__form" action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            {{-- メールアドレス入力 --}}
            <div class="login-form__group">
                <label class="login-form__label" for="email"><img src="images/icon/email.png" alt="Email Icon" class="icon"></label>
                <div class="login-form__field">
                    <input class="login-form__input" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                    <p class="error-message">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            {{-- パスワード入力 --}}
            <div class="login-form__group">
                <label class="login-form__label" for="password"><img src="images/icon/password.png" alt="Password Icon" class="icon"></label>
                <div class="login-form__field">
                    <input class="login-form__input" type="password" name="password" id="password" placeholder="Password">
                    <p class="error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="login-form__btn">
                {{-- ログインボタン --}}
                <input class="login-form__btn--submit" type="submit" value="ログイン">
            </div>
        </form>
    </div>
</div>
@endsection