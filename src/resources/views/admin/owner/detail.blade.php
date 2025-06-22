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
        <form method="POST" action="{{ route('admin.owner.update', $owner->id) }}">
            @csrf
            @method('PUT')

            <div class="owner-detail__info">
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

                <div class="owner-detail__btn">
                    <button type="submit" class="owner-detail__btn--update">更新する</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection