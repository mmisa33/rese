@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/owner/create.css') }}">
@endsection

@section('content')
<div class="owner-create">
    <div class="owner-create__title">
        <a href="{{ route('admin.index') }}" class="back-btn">&lt;</a>
        <h2 class="owner-create__name">店舗代表者アカウント作成</h2>
    </div>

    {{-- 店舗代表者作成フォーム --}}
    <div class="owner-create__form">
        <form method="POST" action="{{ route('admin.owner.store') }}" class="owner-form" novalidate>
            @csrf

            <div class="owner-form__content">
                <h3 class="owner-form__title">新しい店舗代表者を登録</h3>

                {{-- 名前 --}}
                <div class="register-form__group">
                    <label class="register-form__label" for="name"><img src="{{ asset('images/icon/user.png') }}" alt="User Icon" class="icon"></label>
                    <div class="owner-form__field">
                        <input type="text" name="name" placeholder="Owner Name" class="owner-form__input" value="{{ old('name') }}">
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- メール --}}
                <div class="register-form__group">
                    <label class="register-form__label" for="email"><img src="{{ asset('images/icon/email.png') }}" alt="Email Icon" class="icon"></label>
                    <div class="owner-form__field">
                        <input type="email" name="email" placeholder="Email" class="owner-form__input" value="{{ old('email') }}">
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- パスワード --}}
                <div class="register-form__group">
                    <label class="register-form__label" for="password"><img src="{{ asset('images/icon/password.png') }}" alt="Password Icon" class="icon"></label>
                    <div class="owner-form__field">
                        <input type="password" name="password" placeholder="Password" class="owner-form__input">
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="owner-form__btn">作成する</button>
        </form>
    </div>
</div>
@endsection