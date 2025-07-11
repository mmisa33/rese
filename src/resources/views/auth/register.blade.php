@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shared/auth/form.css') }}">
@endsection

@section('content')
<div class="auth-form">
    @include('shared.auth.form', [
        'route' => 'register',
        'headerText' => 'Registration',
        'buttonText' => '登録',
        'hasName' => true,
    ])
</div>
@endsection