@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops/index.css')}}">
@endsection

@section('content')
<div class="">
    {{-- ログアウト --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="">ログアウト</button>
    </form>
</div>
@endsection