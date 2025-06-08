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

{{-- 店舗一覧 --}}
{{-- <div class="shop__list">
    <div class="item__grid-container">
        @foreach ($items as $item)
            <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item__card-link">
                <div class="item__card">
                    <img class="item__card-image" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                    <p class="item__card-title">
                        @if ($item->sold_status)
                            <span class="item__card-label">Sold</span>
                        @endif
                        {{ $item->name }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection --}}