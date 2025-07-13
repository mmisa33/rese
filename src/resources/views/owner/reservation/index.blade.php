@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/reservation/index.css') }}">
@endsection

@section('content')
<div class="owner-reservation">
    <div class="owner-reservation__title">
        <a href="{{ route('owner.index') }}" class="back-btn">&lt;</a>
        <h2 class="owner-reservation__header">予約一覧</h2>
    </div>

    {{-- 検索ボックス --}}
    <form method="GET" action="{{ route('owner.reservation') }}" class="search-form search-form__reservation" id="search-form">

        {{-- 月指定検索 --}}
        <div class="search-form__group search-form__group--month">
            <input type="month" name="month" value="{{ request('month') }}" class="search-form__month-input">
        </div>

        {{-- 並び順 --}}
        <div class="search-form__group search-form__group--sort">
            <select name="sort" class="search-form__select">
                <option value="" disabled selected>並び替え</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>昇順</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>降順</option>
            </select>
            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="search-form__select-icon">
        </div>

        {{-- 来店状況 --}}
        <div class="search-form__group search-form__group--status">
            <select name="visit_status" class="search-form__select">
                <option value="">来店状況</option>
                <option value="visited" {{ request('visit_status') == 'visited' ? 'selected' : '' }}>来店済</option>
                <option value="upcoming" {{ request('visit_status') == 'upcoming' ? 'selected' : '' }}>来店前</option>
            </select>
            <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="search-form__select-icon">
        </div>

        {{-- キーワード --}}
        <button type="submit" class="search-form__btn">
            <img src="{{ asset('images/icon/search.png') }}" alt="Search" class="keyword-icon">
        </button>
        <input type="text" name="keyword" placeholder="ユーザー名検索" value="{{ request('keyword') }}" class="search-form__keyword">
    </form>

    {{-- 予約一覧 --}}
    @if (isset($shopExists) && !$shopExists)
        <p class="owner-reservation__empty">店舗情報が作成されていません</p>
    @else
        @if ($reservations->isEmpty())
            <p class="owner-reservation__empty">予約はありません</p>
        @else
            <table class="reservation-table">
                <thead class="reservation-table__thead">
                    <tr class="reservation-table__row">
                        <th class="reservation-table__head">予約日</th>
                        <th class="reservation-table__head">ユーザー名</th>
                        <th class="reservation-table__head">時間</th>
                        <th class="reservation-table__head">人数</th>
                        <th class="reservation-table__head">来店状況</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr class="reservation-table__row">
                            <td class="reservation-table__content">{{ $reservation->date }}</td>
                            <td class="reservation-table__content">{{ $reservation->user->name }}</td>
                            <td class="reservation-table__content">{{ $reservation->time }}</td>
                            <td class="reservation-table__content">{{ $reservation->number }}人</td>
                            <td class="reservation-table__content">{{ $reservation->visit_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ページネーション --}}
            <div class="pagination">
                {{ $reservations->appends(request()->query())->links() }}
            </div>
        @endif
    @endif

{{-- 検索ボックス選択時に自動で絞り込み --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('search-form');

        form.querySelectorAll('select, input[type="month"]').forEach(element => {
            element.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>
@endsection