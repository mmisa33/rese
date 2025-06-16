@extends('layouts.app')

@section('content')
<div class="review-form">
    <h2>評価を投稿</h2>
    <p>店舗：{{ $reservation->shop->name }}</p>
    <form method="POST" action="{{ route('review.store', ['reservation_id' => $reservation->id]) }}">
        @csrf

        <label>評価（1〜5）</label>
        <select name="rating" required>
            <option value="">選択してください</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('rating')
            <p class="error">{{ $message }}</p>
        @enderror

        <label>コメント（任意）</label>
        <textarea name="comment" rows="5">{{ old('comment') }}</textarea>
        @error('comment')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">評価を送信</button>
    </form>
</div>
@endsection
