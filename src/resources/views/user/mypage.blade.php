@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/mypage.css')}}">
@endsection

@section('content')
<div class="mypage">
    {{-- ユーザー名 --}}
    <h2 class="mypage__user-name">{{ $user->name }}さん</h2>

    <div class="mypage-container">
        {{-- 予約飲食店一覧 --}}
        <div class="mypage__reservation">
            <h3 class="mypage__reservation-title">予約状況</h3>

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
            <div class="flash-message">
                {{ session('status') }}
            </div>
            @endif

            <div class="reservation-list">
                @forelse ($reservations as $index => $reservation)
                    <div class="reservation-card">
                        <div class="reservation-card__title">
                            <img src="{{ asset('images/icon/clock.png') }}" alt="Clock Icon" class="icon">
                            <div class="reservation-card__header-name">予約{{ $index + 1 }}</div>

                            {{-- 削除ボタン（来店前のみ） --}}
                            @if ($reservation->isFuture)
                                <div class="reservation-card__btn">
                                    <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}" class="reservation-form__delete" data-reservation-id="{{ $reservation->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button">
                                            <img src="{{ asset('images/icon/delete.png') }}" alt="Delete Icon" class="icon">
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- 予約内容 --}}
                        <table class="reservation-card__table">
                            <tr class="reservation-card__row">
                                <th class="reservation-card__header">Shop</th>
                                <td class="reservation-card__cell">{{ $reservation->shop->name }}</td>
                            </tr>
                            <tr class="reservation-card__row">
                                <th class="reservation-card__header">Date</th>
                                <td class="reservation-card__cell" id="confirm-date">{{ $reservation->date }}</td>
                            </tr>
                            <tr class="reservation-card__row">
                                <th class="reservation-card__header">Time</th>
                                <td class="reservation-card__cell" id="confirm-time">{{ $reservation->time }}</td>
                            </tr>
                            <tr class="reservation-card__row">
                                <th class="reservation-card__header">Number</th>
                                <td class="reservation-card__cell" id="confirm-number">{{ $reservation->number }}人</td>
                            </tr>
                        </table>

                        {{-- フッター：予約変更＆レビュー --}}
                        <div class="reservation-card__footer">
                            {{-- 予約変更 --}}
                            @if ($reservation->isFuture)
                                <a href="{{ route('reservation.edit', $reservation->id) }}" class="footer-btn active">予約変更</a>
                            @else
                                <span class="footer-btn disabled">予約変更</span>
                            @endif

                            {{-- レビュー --}}
                            @if (!$reservation->isFuture && !$reservation->review)
                                <a href="{{ route('review.create', ['reservation_id' => $reservation->id]) }}" class="footer-btn active">レビュー</a>
                            @elseif (!$reservation->isFuture && $reservation->review)
                                <span class="footer-btn done">評価済み</span>
                            @else
                                <span class="footer-btn disabled">レビュー</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="empty-message">予約はありません</p>
                @endforelse
            </div>
        </div>

        {{-- いいね一覧 --}}
        <div class="mypage__like">
            <h3 class="mypage__like-title">お気に入り店舗</h3>
            <div class="shop__grid-container">
                @forelse ($favorites as $favorite)
                    <div class="shop__card">
                        {{-- イメージ画像 --}}
                        <img src="{{ Storage::url($favorite->shop->image_path) }}" alt="{{ $favorite->shop->name }}" class="shop__card-image">

                        <div class="shop__card-body">
                            {{-- 飲食店名 --}}
                            <h3 class="shop__card-title">
                                {{ $favorite->shop->name }}
                            </h3>

                            {{-- タグ --}}
                            <p class="shop__card-tags">
                                <span>#{{ $favorite->shop->area->name }}</span>
                                <span>#{{ $favorite->shop->genre->name }}</span>
                            </p>

                            {{-- 詳細ボタン --}}
                            <div class="shop__card-actions">
                                <div class="shop__details-btn">
                                    <a href="{{ route('shop.show', ['shop_id' => $favorite->shop->id]) }}" class="shop__details-btn--submit">詳しくみる</a>
                                </div>

                                {{-- いいねボタン --}}
                                <div class="shop__like-btn">
                                    @auth
                                        <form method="POST" action="{{ route('shop.like', ['shop_id' => $favorite->shop->id]) }}" class="shop__like-form">
                                            @csrf
                                            <button type="submit" class="shop__like-button">
                                                @if (auth()->user()->likes->contains('id', $favorite->shop->id))
                                                    <i class="fa-solid fa-heart liked"></i>
                                                @else
                                                    <i class="fa-solid fa-heart not-liked"></i>
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="shop__like-button">
                                            <i class="fa-regular fa-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-message">お気に入り店舗はありません</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection