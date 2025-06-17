@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/owner/detail.css') }}">
@endsection

@section('content')
<div class="owner-detail">
    <div class="owner-detail__title">
        <a href="{{ route('admin.index') }}" class="back-btn">&lt;</a>
        <h2 class="owner-detail__title">店舗代表者情報</h2>
    </div>

    {{-- 詳細情報 --}}
    <div class="owner-detail__content">
        <div class="owner-detail__info">
            <p class="owner-detail__item"><span class="label">Shop Name</span> {{ $owner->shop->name ?? '未割当' }}</p>
            <p class="owner-detail__item"><span class="label">Owner Name</span> {{ $owner->name }}</p>
            <p class="owner-detail__item"><span class="label">Email</span> {{ $owner->email }}</p>
            {{-- <p class="owner-detail__item"><span class="label">Password</span> {{ $owner->password }}</p> --}}
        </div>
    </div>
</div>
@endsection