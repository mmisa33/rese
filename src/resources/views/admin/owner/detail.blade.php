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

    <div class="owner-detail__content">
        <div class="owner-detail__info">
            <form method="POST" action="{{ route('admin.owner.destroy', $owner->id) }}">
                @csrf
                @method('DELETE')
                <div class="owner-detail__btn">
                    <button type="submit" class="owner-detail__btn--delete" onclick="return confirm('本当に削除してもよろしいですか？')"><img src="{{ asset('images/icon/delete02.png') }}" alt="Delete Icon" class="icon"></button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.owner.update', $owner->id) }}">
                @csrf
                @method('PUT')

                @if (session('error'))
                    <div class="flash-message error">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="owner-detail__item">
                    <label class="label" for="shop_name">Shop Name</label>
                    <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', optional($owner->shop)->name ?? '店舗情報が作成されていません') }}"
                    @if(!$owner->shop) disabled @endif>
                    @error('shop_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="owner-detail__item">
                    <label class="label" for="owner_name">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name', $owner->name) }}">
                    @error('owner_name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="owner-detail__item">
                    <label class="label" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $owner->email) }}">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="owner-detail__item">
                    <label class="label" for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="更新する場合のみ入力してください" autocomplete="new-password">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="owner-detail__btn">
                    <button type="submit" class="owner-detail__btn--update">更新する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection