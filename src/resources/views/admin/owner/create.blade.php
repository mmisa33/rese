@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/owner/create.css') }}">
@endsection

@section('content')
<div class="owner-create">
    <div class="owner-create__title">
        <a href="{{ route('admin.index') }}" class="back-btn">&lt;</a>
        <h2 class="owner-create__name">店舗代表者作成</h2>
    </div>

    {{-- オーナー作成フォーム --}}
    <div class="owner-create__form">
        <form method="POST" action="{{ route('admin.owner.store') }}" class="owner-form" novalidate>
            @csrf

            <div class="owner-form__content">
                <h3 class="owner-form__title">作成フォーム</h3>

                {{-- 名前 --}}
                <div class="owner-form__field">
                    <input type="text" name="name" placeholder="名前" class="owner-form__input" value="{{ old('name') }}">
                </div>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- メール --}}
                <div class="owner-form__field">
                    <input type="email" name="email" placeholder="メールアドレス" class="owner-form__input" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- パスワード --}}
                <div class="owner-form__field">
                    <input type="password" name="password" placeholder="パスワード" class="owner-form__input">
                </div>
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="owner-form__btn">作成する</button>
        </form>
    </div>
</div>
@endsection