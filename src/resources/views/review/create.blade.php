@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review/create.css') }}">
@endsection

@section('content')
<div class="review-post">
    <div class="review-post__title">
        <a href="{{ route('mypage') }}" class="back-btn">&lt;</a>
        <h2 class="review-post__name">{{ $reservation->shop->name }}のレビュー</h2>
    </div>

    <div class="review-post__form">
        <form method="POST" action="{{ route('review.store', ['reservation_id' => $reservation->id]) }}" class="review-form" novalidate>
            @csrf
            <div class="review-form__content">
                <h3 class="review-form__title">
                    ご来店ありがとうございました<br>
                    よろしければ評価をお願いします
                </h3>

                {{-- 星評価 --}}
                <div class="review-form__stars">
                    <div class="stars-label-row">
                        <p class="review-form__label">満足度（1〜5）：</p>
                        <div class="stars" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}">&#9733;</span>
                            @endfor
                        </div>
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
                    @error('rating')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- コメント --}}
                <div class="review-form__textarea">
                    <label for="comment" class="review-form__label">コメント（任意）</label>
                    <textarea name="comment" id="comment" rows="5" placeholder="お店の雰囲気・味・接客など">{{ old('comment') }}</textarea>
                </div>
                @error('comment')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="review-form__btn">投稿する</button>
        </form>
    </div>
</div>

{{-- 星評価JS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        const oldRating = parseInt(ratingInput.value);
        if (oldRating) {
            stars.forEach((star, index) => {
                if (index < oldRating) star.classList.add('active');
            });
        }

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.getAttribute('data-value'));
                ratingInput.value = value;

                stars.forEach((s, i) => {
                    s.classList.toggle('active', i < value);
                });
            });
        });
    });
</script>
@endsection
