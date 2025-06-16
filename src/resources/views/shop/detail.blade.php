@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop/detail.css')}}">
@endsection

@section('content')
<div class="shop-detail">

    {{-- 飲食店情報 --}}
    <div class="shop-detail__info">
        <div class="info__title">
            {{-- 戻るボタン --}}
            <a href="{{ route('shop.index') }}" class="back-btn">&lt;</a>

            {{-- 飲食店名 --}}
            <h2 class="info__name">
                {{ $shop->name }}
            </h2>
        </div>

        {{-- イメージ画像 --}}
        <div class="info__img">
            <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}">
        </div>

        {{-- タグ --}}
        <p class="info__tags">
            <span>#{{ $shop->area->name }}</span>
            <span>#{{ $shop->genre->name }}</span>
        </p>

        {{-- 飲食店説明 --}}
        <div class="info__description">
            {{ $shop->description }}
        </div>
    </div>

    {{-- 予約フォーム --}}
    <div class="shop-detail__reservation-form">
        <form action="{{ route('reservation.store') }}" method="POST" class="reservation-form" novalidate>
            @csrf
            <div class="reservation-form__content">
                <h3 class="reservation-form__title">予約</h3>

                <div class="reservation-form__group">
                    {{-- 日付選択 --}}
                    <div class="reservation-form__select">
                        <input class="reservation-form__select--date" type="date" name="date" id="date" value="{{ old('date') }}">
                        @error('date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 時間選択 --}}
                    <div class="reservation-form__select select-wrapper">
                        <select class="reservation-form__select--time" name="time" id="time">
                            <option value="">時間を選択</option>
                            @foreach ($timeOptions as $time)
                            <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                        <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                        @error('time')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 人数選択 --}}
                    <div class="reservation-form__select select-wrapper">
                        <select class="reservation-form__select--number" name="number" id="number">
                            <option value="">人数を選択</option>
                            @foreach ($peopleOptions as $num)
                            <option value="{{ $num }}" {{ old('number') == $num ? 'selected' : '' }}>{{ $num }}人</option>
                            @endforeach
                        </select>
                        <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                        @error('number')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 確認欄 --}}
                <div class="reservation-form__confirm">
                    <table class="reservation-form__table">
                        <tr class="reservation-form__row">
                            <th class="reservation-form__header">Shop</th>
                            <td class="reservation-form__cell">{{ $shop->name }}</td>
                        </tr>
                        <tr class="reservation-form__row">
                            <th class="reservation-form__header">Date</th>
                            <td class="reservation-form__cell" id="confirm-date">未選択</td>
                        </tr>
                        <tr class="reservation-form__row">
                            <th class="reservation-form__header">Time</th>
                            <td class="reservation-form__cell" id="confirm-time">未選択</td>
                        </tr>
                        <tr class="reservation-form__row">
                            <th class="reservation-form__header">Number</th>
                            <td class="reservation-form__cell" id="confirm-number">未選択</td>
                        </tr>
                    </table>
                </div>

                {{-- hidden shop_id --}}
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            </div>

            {{-- ボタン --}}
            <button type="submit" class="reservation-form__btn">予約する</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const date = document.getElementById('date');
        const time = document.getElementById('time');
        const number = document.getElementById('number');
        const confirmDate = document.getElementById('confirm-date');
        const confirmTime = document.getElementById('confirm-time');
        const confirmNumber = document.getElementById('confirm-number');

        function updateConfirm() {
            confirmDate.textContent = date.value || '未選択';
            confirmTime.textContent = time.value || '未選択';
            confirmNumber.textContent = number.value ? number.value + '人' : '未選択';
        }

        [date, time, number].forEach(el => el.addEventListener('change', updateConfirm));
    });
</script>
@endsection