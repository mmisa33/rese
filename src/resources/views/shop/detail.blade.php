@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop/detail.css')}}">
@endsection

@section('content')
<div class="shop-detail">

    {{-- 店舗情報 --}}
    <div class="shop-detail__info">
        <div class="info__title">
            {{-- 戻るボタン --}}
            <div class="info__back">
                <a href="{{ route('shop.index') }}" class="info__back-link">&lt;</a>
            </div>

            {{-- 店舗名 --}}
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

        {{-- 店舗説明 --}}
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

                <div class="reservation-form__select">
                    {{-- 日付選択 --}}
                    <div class="reservation-form__select--date">
                        <input type="date" name="date" id="date">
                        @error('date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 時間選択 --}}
                    <div class="reservation-form__select--time">
                        <select name="time" id="time">
                            <option value="">時間を選択</option>
                            @for ($h = 11; $h <= 22; $h++)
                                <option value="{{ $h }}:00">{{ $h }}:00</option>
                                <option value="{{ $h }}:30">{{ $h }}:30</option>
                            @endfor
                        </select>
                        @error('time')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 人数選択 --}}
                    <div class="reservation-form__select--number">
                        <select name="number" id="number">
                            <option value="">人数を選択</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}人</option>
                            @endfor
                        </select>
                        @error('number')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 確認欄 --}}
                <div class="reservation-form__confirm">
                    <table class="reservation-form__confirm-table">
                        <tr class="reservation-form__confirm-row">
                            <th class="reservation-form__confirm-header">Shop</th>
                            <td class="reservation-form__confirm-content">{{ $shop->name }}</td>
                        </tr>
                        <tr class="reservation-form__confirm-row">
                            <th class="reservation-form__confirm-header">Date</th>
                            <td class="reservation-form__confirm-content" id="confirm-date">未選択</td>
                        </tr>
                        <tr class="reservation-form__confirm-row">
                            <th class="reservation-form__confirm-header">Time</th>
                            <td class="reservation-form__confirm-content" id="confirm-time">未選択</td>
                        </tr>
                        <tr class="reservation-form__confirm-row">
                            <th class="reservation-form__confirm-header">Number</th>
                            <td class="reservation-form__confirm-content" id="confirm-number">未選択</td>
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