@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify.css')}}">
@endsection

@section('content')
<div class="email-verification">
    <div class="email-verification__inner">
        <h2 class="verification-message">登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。</h2>

        <a href="http://localhost:8025" class="verification-link" target="_blank" rel="noopener noreferrer">認証はこちらから</a>
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form class="resend-form" action="{{ route('verification.send') }}" method="POST">
            @csrf
            <input class="resend-form__link" type="submit" value="認証メールを再送する">
        </form>
    </div>
</div>
@endsection