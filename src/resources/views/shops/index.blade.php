@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops/index.css')}}">
@endsection

@section('link')
{{-- 検索ボックス --}}
<div class="header__search">
    <form class="search-form" action="" method="get">

        {{-- 地域 --}}
        <div class="search-form__area">
            <select class="search-form__area-select" name="area">
                <option value="" {{ request('area') == '' ? 'selected' : '' }}>All area</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            <img src="images/icon/select.png" alt="Select Icon" class="select-icon">
        </div>

        {{-- ジャンル --}}
        <div class="search-form__genre">
            <select class="search-form__genre-select" name="genre">
                <option value="" {{ request('genre') == '' ? 'selected' : '' }}>All genre</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            <img src="images/icon/select.png" alt="Select Icon" class="select-icon">
        </div>

        {{-- キーワード --}}
        <button type="submit" class="search-button">
            <img src="images/icon/search.png" alt="Search" class="keyword-icon">
        </button>
        <input class="search-form__keyword-input" type="text" name="keyword" placeholder="Search &hellip;" value="{{ request('keyword') }}">
    </form>
</div>
@endsection

@section('content')
{{-- 店舗一覧 --}}
<div class="shop__list">
    <div class="shop__grid-container">
        @foreach ($shops as $shop)
            <div class="shop__card">
                {{-- イメージ画像 --}}
                {{-- <img class="shop__card-image" src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}"> --}}
                <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" class="shop__card-image">

                <div class="shop__card-body">
                    {{-- 店舗名 --}}
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
                                <form method="POST" action="{{ route('shops.like', ['shop_id' => $shop->id]) }}" class="shop__like-form">
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
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection