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
            @include('shared.shop.card', ['shop' => $shop])
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