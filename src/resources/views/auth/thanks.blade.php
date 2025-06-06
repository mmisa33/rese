@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/thanks.css')}}">
@endsection

@section('content')
<div class="thanks-form">

    <div class="thanks-form__inner">
        <h2 class="thanks-form__message">
            会員登録ありがとうございます
        </h2>

        {{-- トップページへ移行 --}}
        <div class="thanks-form__login">
            <a class="thanks-form__login--link" href="{{ route('shops.index') }}">ログインする</a>
        </div>
    </div>
</div>
@endsection