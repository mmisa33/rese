@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<div class="register-form">

    {{-- ユーザー登録フォーム --}}
    <div class="register-form__inner">

        <div class="register-form__header">Registration</div>

        <form class="register-form__form" action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            {{-- 名前入力 --}}
            <div class="register-form__group" @error('name') has-error @enderror">
                <label class="register-form__label" for="name"><img src="images/icon/user.png" alt="User Icon" class="icon"></label>
                <div class="register-form__field">
                    <input class="register-form__input" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Username">
                    <p class="error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            {{-- メールアドレス入力 --}}
            <div class="register-form__group">
                <label class="register-form__label" for="email"><img src="images/icon/email.png" alt="Email Icon" class="icon"></label>
                <div class="register-form__field">
                    <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                    <p class="error-message">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            {{-- パスワード入力 --}}
            <div class="register-form__group">
                <label class="register-form__label" for="password"><img src="images/icon/password.png" alt="Password Icon" class="icon"></label>
                <div class="register-form__field">
                    <input class="register-form__input" type="password" name="password" id="password" placeholder="Password">
                    <p class="error-message">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="register-form__btn">
                {{-- 登録ボタン --}}
                <input class="register-form__btn--submit" type="submit" value="登録">
            </div>
        </form>
    </div>
</div>
@endsection