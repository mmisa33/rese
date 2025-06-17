@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review/create.css') }}">
@endsection

@section('content')
<div class="review-post">
    <div class="review-post__title">
        <a href="{{ route('mypage') }}" class="back-btn">&lt;</a>
        <h2 class="review-post__name">レビュー投稿</h2>
    </div>

    <div class="review-post__form">
        <form method="POST" action="{{ route('review.store', ['reservation_id' => $reservation->id]) }}" class="review-form" novalidate>
            @csrf
            <div class="review-form__content">
                <h3 class="review-form__title">ご来店ありがとうございました<br>お店のご感想をお聞かせください</h3>

                {{-- 店舗名 --}}
                <div class="review-form__shop">
                    <p>店舗：{{ $reservation->shop->name }}</p>
                </div>

                {{-- 評価 --}}
                <div class="review-form__select select-wrapper">
                    <select class="review-form__select--rating" name="rating" required>
                        <option value="">評価（1〜5）を選択</option>
                        @foreach ($ratings as $rating)
                            <option value="{{ $rating }}" {{ old('rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                        @endforeach
                    </select>
                    <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
                </div>
                @error('rating')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                {{-- コメント --}}
                <div class="review-form__textarea">
                    <textarea name="comment" rows="5" placeholder="コメント（任意）">{{ old('comment') }}</textarea>
                </div>
                @error('comment')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="review-form__btn">評価を送信</button>
        </form>
    </div>
</div>
@endsection