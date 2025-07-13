@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/shop/index.css')}}">
@endsection

@section('link')
{{-- 検索ボックス --}}
<div class="header__search">
    <form id="search-form" class="search-form" action="" method="get">

        {{-- 地域 --}}
        <div class="search-form__group search-form__group--area">
            <select name="area" class="search-form__select auto-submit">
                <option value="" {{ request('area') == '' ? 'selected' : '' }}>All area</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="search-form__select-icon">
        </div>

        {{-- ジャンル --}}
        <div class="search-form__group search-form__group--genre">
            <select name="genre" class="search-form__select auto-submit">
                <option value="" {{ request('genre') == '' ? 'selected' : '' }}>All genre</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="search-form__select-icon">
        </div>

        {{-- キーワード --}}
        <button type="submit" class="search-form__btn">
            <img src="{{ asset('images/icon/search.png') }}" alt="Search" class="keyword-icon">
        </button>
        <input type="text" name="keyword" placeholder="Search &hellip;" value="{{ request('keyword') }}" class="search-form__keyword">
    </form>
</div>
@endsection

@section('content')
{{-- 飲食店一覧 --}}
<div class="shop__list">
    <div class="shop__grid-container">
        @foreach ($shops as $shop)
            <div class="shop__card">
                {{-- イメージ画像 --}}
                <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" class="shop__card-image">

                <div class="shop__card-body">
                    {{-- 飲食店名 --}}
                    <h3 class="shop__card-title">
                        {{ $shop->name }}
                    </h3>

                    {{-- タグ --}}
                    <p class="shop__card-tags">
                        <span>#{{ $shop->area->name }}</span>
                        <span>#{{ $shop->genre->name }}</span>
                    </p>

                    {{-- 詳細ボタン --}}
                    <div class="shop__card-actions">
                        <div class="shop__details-btn">
                            <a href="{{ route('shop.show', ['shop_id' => $shop->id]) }}" class="shop__details-btn--submit">詳しくみる</a>
                        </div>

                        {{-- いいねボタン --}}
                        <div class="shop__like-btn">
                            @auth
                                <form method="POST" action="{{ route('shop.like', ['shop_id' => $shop->id]) }}" class="shop__like-form">
                                    @csrf
                                    <button type="submit" class="shop__like-button">
                                        @if (auth()->user()->likes->contains('id', $shop->id))
                                            <i class="fa-solid fa-heart liked"></i>
                                        @else
                                            <i class="fa-solid fa-heart not-liked"></i>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="shop__like-button">
                                    <i class="fa-solid fa-heart not-liked"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- 検索ボックス選択時に自動で絞り込み --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('search-form');
        document.querySelectorAll('.auto-submit').forEach(el => {
            el.addEventListener('change', () => form.submit());
        });
    });
</script>
@endsection