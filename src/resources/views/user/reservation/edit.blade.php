@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/reservation/edit.css') }}">
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
                    <input class="reservation-form__select--date" type="date" id="date" name="date" value="{{ old('date', $reservation->date) }}">
                </div>

                {{-- 時間 --}}
                <div class="reservation-form__select select-wrapper">
                    <select class="reservation-form__select--time" id="time" name="time">
                        <option value="">時間を選択</option>
                        @foreach ($timeOptions as $time)
                        <option value="{{ $time }}" {{ old('time', $reservation->time) == $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/icon/select.png') }}" alt="選択アイコン" class="select-icon">
                </div>

                {{-- 人数 --}}
                <div class="reservation-form__select select-wrapper">
                    <select class="reservation-form__select--number" id="number" name="number">
                        <option value="">人数を選択</option>
                        @foreach ($peopleOptions as $num)
                        <option value="{{ $num }}" {{ old('number', $reservation->number) == $num ? 'selected' : '' }}>{{ $num }}人</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/icon/select.png') }}" alt="選択アイコン" class="select-icon">
                </div>

                {{-- 確認欄 --}}
                <div class="reservation-form__confirm">
                    <table class="reservation-form__table">
                        <tr><th class="reservation-form__header">Shop</th><td class="reservation-form__cell">{{ $reservation->shop->name }}</td></tr>
                        <tr><th class="reservation-form__header">Date</th><td class="reservation-form__cell" id="confirm-date">{{ old('date', $reservation->date) }}</td></tr>
                        <tr><th class="reservation-form__header">Time</th><td class="reservation-form__cell" id="confirm-time">{{ old('time', $reservation->time) }}</td></tr>
                        <tr><th class="reservation-form__header">Number</th><td class="reservation-form__cell" id="confirm-number">{{ old('number', $reservation->number) }}人</td></tr>
                    </table>
                </div>
            </div>

            <button type="submit" class="reservation-form__btn">更新する</button>
        </form>
    </div>
</div>

{{-- 選択項目を確認欄に即時反映 --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');
        const numberSelect = document.getElementById('number');
        const confirmDate = document.getElementById('confirm-date');
        const confirmTime = document.getElementById('confirm-time');
        const confirmNumber = document.getElementById('confirm-number');

        function updateConfirm() {
            confirmDate.textContent = dateInput.value || '未選択';
            confirmTime.textContent = timeSelect.value || '未選択';
            confirmNumber.textContent = numberSelect.value ? numberSelect.value + '人' : '未選択';
        }

        [dateInput, timeSelect, numberSelect].forEach(el => {
            if (el) el.addEventListener('change', updateConfirm);
        });

        updateConfirm(); // 初期状態でも反映
    });
</script>
@endsection