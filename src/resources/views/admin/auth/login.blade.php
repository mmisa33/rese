@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common/auth/form.css') }}">
@endsection

@section('content')
    <div class="auth-form">
        @include('common.auth.form', [
            'route' => 'admin.login',
            'headerText' => 'Admin Login',
            'buttonText' => 'ログイン',
        ])
    </div>
@endsection
