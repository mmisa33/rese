@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation/edit.css') }}">
@endsection

@section('content')
<div class="reservation-edit">
    <div class="reservation-edit__title">
        <a href="{{ route('mypage') }}" class="back-btn">&lt;</a>
        <h2 class="reservation-edit__name">予約変更</h2>
    </div>

    {{-- 予約変更フォーム --}}
    <div class="reservation-edit__form">
        <form action="{{ route('reservation.update', ['id' => $reservation->id]) }}" method="POST" class="reservation-form">
            @csrf
            @method('PUT')

            <div class="reservation-form__content">
                <h3 class="reservation-form__title">予約内容の変更</h3>

                {{-- 日付 --}}
                <div class="reservation-form__select">
                    <input class="reservation-form__select--date" type="date" name="date" value="{{ old('date', $reservation->date) }}">
                </div>
                @error('date')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- 時間 --}}
                <div class="reservation-form__select select-wrapper">
                    <select class="reservation-form__select--time" name="time">
                        <option value="">時間を選択</option>
                        @foreach ($timeOptions as $time)
                        <option value="{{ $time }}" {{ old('time', $reservation->time) == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                </div>
                @error('time')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- 人数 --}}
                <div class="reservation-form__select select-wrapper">
                    <select class="reservation-form__select--number" name="number">
                        <option value="">人数を選択</option>
                        @foreach ($peopleOptions as $num)
                        <option value="{{ $num }}" {{ old('number', $reservation->number) == $num ? 'selected' : '' }}>{{ $num }}人</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                </div>
                @error('number')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- 確認欄 --}}
                <div class="reservation-form__confirm">
                    <table class="reservation-form__table">
                        <tr><th class="reservation-form__header">Shop</th><td class="reservation-form__cell">{{ $reservation->shop->name }}</td></tr>
                        <tr><th class="reservation-form__header">Date</th><td class="reservation-form__cell">{{ old('date', $reservation->date) }}</td></tr>
                        <tr><th class="reservation-form__header">Time</th><td class="reservation-form__cell">{{ old('time', $reservation->time) }}</td></tr>
                        <tr><th class="reservation-form__header">Number</th><td class="reservation-form__cell">{{ old('number', $reservation->number) }}人</td></tr>
                    </table>
                </div>
            </div>

            <button type="submit" class="reservation-form__btn">更新する</button>
        </form>
    </div>
</div>
@endsection