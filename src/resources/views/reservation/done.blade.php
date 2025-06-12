@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation/done.css')}}">
@endsection

@section('content')
<div class="done-form">

    <div class="done-form__inner">
        <h2 class="done-form__message">
            ご予約ありがとうございます
        </h2>

        {{-- トップページへ移行 --}}
        <div class="done-form__home">
            <a class="done-form__home--link" href="{{ route('shop.index') }}">戻る</a>
        </div>
    </div>
</div>
@endsection