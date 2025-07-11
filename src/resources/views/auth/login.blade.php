@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shared/auth/form.css') }}">
@endsection

@section('content')
<div class="auth-form">
    @include('shared.auth.form', [
        'route' => 'login',
        'headerText' => 'Login',
        'buttonText' => 'ログイン',
    ])
</div>
@endsection