@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
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
                                        <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}"
                                            class="reservation-form__delete" data-reservation-id="{{ $reservation->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-button">
                                                <img src="{{ asset('images/icon/delete.png') }}" alt="Delete Icon"
                                                    class="icon">
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

                            {{-- フッター：予約変更・QRコード・レビュー --}}
                            <div class="reservation-card__footer">
                                {{-- 予約変更 --}}
                                @if ($reservation->isFuture)
                                    <a href="{{ route('reservation.edit', $reservation->id) }}"
                                        class="footer-btn active">予約変更</a>
                                @else
                                    <span class="footer-btn disabled">予約変更</span>
                                @endif

                                {{-- QRコード --}}
                                @if ($reservation->isFuture)
                                    <a href="#" class="footer-btn active qr-trigger"
                                        data-reservation-id="{{ $reservation->id }}">QRコード</a>

                                    {{-- モーダル本体 --}}
                                    <div class="qr-modal" id="qr-modal-{{ $reservation->id }}" style="display: none;">
                                        <div class="qr-modal__content">
                                            <span class="qr-modal__close"
                                                data-reservation-id="{{ $reservation->id }}">&times;</span>
                                            <p class="qr-modal__name">{{ $reservation->shop->name }}</strong>の予約QRコード</p>
                                            {!! QrCode::size(200)->generate(route('reservation.verify', ['id' => $reservation->id])) !!}
                                        </div>
                                    </div>
                                @else
                                    <span class="footer-btn disabled">QRコード</span>
                                @endif

                                {{-- レビュー --}}
                                @if (!$reservation->isFuture && !$reservation->review)
                                    <a href="{{ route('review.create', ['reservation_id' => $reservation->id]) }}"
                                        class="footer-btn active">レビュー</a>
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

            {{-- いいね店舗一覧 --}}
            <div class="mypage__like">
                <h3 class="mypage__like-title">お気に入り店舗</h3>
                <div class="mypage__grid-container">
                    @forelse ($favorites as $favorite)
                        @include('common.shop.card', ['shop' => $favorite->shop])
                    @empty
                        <p class="empty-message">お気に入り店舗はありません</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // モーダルを開く
            document.querySelectorAll('.qr-trigger').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = btn.dataset.reservationId;
                    const modal = document.getElementById('qr-modal-' + id);
                    if (modal) modal.style.display = 'flex';
                });
            });

            // モーダルを閉じる
            document.querySelectorAll('.qr-modal__close').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = btn.dataset.reservationId;
                    const modal = document.getElementById('qr-modal-' + id);
                    if (modal) modal.style.display = 'none';
                });
            });

            // 背景クリックで閉じる
            document.querySelectorAll('.qr-modal').forEach(function(modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) modal.style.display = 'none';
                });
            });
        });
    </script>
@endsection
