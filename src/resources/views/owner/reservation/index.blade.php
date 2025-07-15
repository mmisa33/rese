@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/reservation/index.css') }}">
@endsection

@section('content')
<div class="owner-reservation">
    <div class="page-title">
        <a href="{{ route('owner.index') }}" class="back-btn">&lt;</a>
        <h2>予約一覧</h2>
    </div>

    {{-- 検索ボックス --}}
    <form method="GET" action="{{ route('owner.reservation') }}" class="search-form search-form__reservation" id="search-form">

        {{-- 日付範囲指定 --}}
        <div class="search-form__group search-form__group--date-range">
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="search-form__date-input">
            <span class="search-form__range-separator">〜</span>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="search-form__date-input">
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
        <input type="text" name="keyword" placeholder="ユーザー名" value="{{ request('keyword') }}" class="search-form__keyword">
    </form>

    {{-- 予約一覧 --}}
    @if (isset($shopExists) && !$shopExists)
        <p class="empty-message">店舗情報が作成されていません</p>
    @else
        @if ($reservations->isEmpty())
            <p class="empty-message">予約はありません</p>
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

        form.querySelectorAll('select, input[type="date"]').forEach(element => {
            element.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>
@endsection