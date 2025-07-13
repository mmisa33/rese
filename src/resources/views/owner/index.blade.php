@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/notice/list.css') }}">
@endsection

@section('content')
<div class="owner-home">

    <h2 class="owner-home__header">店舗代表者管理画面</h2>

    <div class="owner-home__container">
        {{-- 店舗情報 --}}
        <div class="shop-info">
            <h3 class="shop-info__title">店舗情報</h3>

            <div class="shop-info__section">
                {{-- 店舗作成・更新フォーム --}}
                <form method="POST" action="{{ isset($shop) ? route('owner.shop.update', $shop->id) : route('owner.shop.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($shop))
                    @method('PUT')
                @endif

                    <div class="shop-info__form">
                        @if(session('success'))
                        <div class="flash-message">
                            {{ session('success') }}
                        </div>
                        @endif

                        {{-- 店舗名 --}}
                        <div class="shop-info__form-group">
                            <label for="name" class="shop-info__form--label">店舗名</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $shop->name ?? '') }}" class="shop-info__form--input">
                        </div>
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        {{-- 画像 --}}
                        <div class="shop-info__form-group">
                            <label for="image"  class="shop-info__form--label">イメージ画像</label>
                            <div class="shop-info__img">
                                <img
                                    id="preview-img"
                                    src="{{ $imageUrl ?: '#' }}"
                                    alt="Shop Image"
                                    style="{{ $imageUrl ? '' : 'display: none;' }}">
                            </div>
                        <input type="file" name="image" id="image" class="shop-info__form--input">
                    </div>
                        @error('image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        {{-- エリア --}}
                        <div class="shop-info__form-group  select-wrapper">
                            <label for="area_id"  class="shop-info__form--label">エリア</label>
                            <select name="area_id" id="area_id" class="shop-info__form--select">
                                <option value="">エリアを選択</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ (old('area_id', $shop->area_id ?? '') == $area->id) ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                        </div>
                        @error('area_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        {{-- ジャンル --}}
                        <div class="shop-info__form-group  select-wrapper">
                            <label for="genre_id"  class="shop-info__form--label">ジャンル</label>
                            <select name="genre_id" id="genre_id" class="shop-info__form--select">
                                <option value="">ジャンルを選択</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ (old('genre_id', $shop->genre_id ?? '') == $genre->id) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                        </div>
                        @error('genre_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror

                        {{-- 説明 --}}
                        <div class="shop-info__form-group">
                            <label for="description" class="shop-info__form--label">店舗説明</label>
                            <textarea name="description" id="description" class="shop-info__form--textarea" rows="4">{{ old('description', $shop->description ?? '') }}</textarea>
                        </div>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="shop-info__btn">
                        {{ isset($shop) ? '更新する' : '登録する' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- お知らせメール一覧 --}}
        @include('shared.notice.list', [
            'title' => 'お知らせメール',
            'createRoute' => route('owner.notice.form'),
            'showRoute' => 'owner.notice.show',
            'notices' => $notices
        ])
    </div>
</div>

{{-- プレビュー用スクリプト --}}
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('preview-img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection