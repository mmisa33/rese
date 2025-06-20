@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/owner/auth/login.css') }}">
@endsection

@section('content')
    <div class="owner-login-form">

        {{-- 店舗代表者用ログインフォーム --}}
        <div class="owner-login-form__inner">

            <div class="owner-login-form__header">Owner Login</div>

            <form class="owner-login-form__form" action="{{ route('owner.login') }}" method="POST" novalidate>
                @csrf

                {{-- メールアドレス入力 --}}
                <div class="owner-login-form__group">
                    <label class="owner-login-form__label" for="email"><img src="{{ asset('images/icon/email.png') }}"
                            alt="Email Icon" class="icon"></label>
                    <div class="owner-login-form__field">
                        <input class="owner-login-form__input" type="email" name="email" id="email"
                            value="{{ old('email') }}" placeholder="Email">
                        <p class="error-message">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>

                {{-- パスワード入力 --}}
                <div class="owner-login-form__group">
                    <label class="owner-login-form__label" for="password"><img
                            src="{{ asset('images/icon/password.png') }}" alt="Password Icon" class="icon"></label>
                    <div class="owner-login-form__field">
                        <input class="owner-login-form__input" type="password" name="password" id="password"
                            placeholder="Password">
                        <p class="error-message">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                </div>

                <div class="owner-login-form__btn">
                    {{-- ログインボタン --}}
                    <input class="owner-login-form__btn--submit" type="submit" value="ログイン">
                </div>
            </form>
        </div>
    </div>
@endsection