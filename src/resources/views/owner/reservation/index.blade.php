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
                        <th class="reservation-table__head">時間</th>
                        <th class="reservation-table__head">人数</th>
                        <th class="reservation-table__head">ユーザー名</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr class="reservation-table__row">
                            <td class="reservation-table__content">{{ $reservation->date }}</td>
                            <td class="reservation-table__content">{{ $reservation->time }}</td>
                            <td class="reservation-table__content">{{ $reservation->number }}人</td>
                            <td class="reservation-table__content">{{ $reservation->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>
@endsection