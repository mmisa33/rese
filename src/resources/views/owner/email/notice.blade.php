@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/email/notice.css') }}">
@endsection

@section('content')
<div class="owner-notice">
    <div class="owner-notice__title">
        <a href="{{ route('owner.index') }}" class="back-btn">&lt;</a>
        <h2>お知らせメール送信</h2>
    </div>

    <div class="owner-notice__content">
        <form method="POST" action="{{ route('owner.notice.send') }}" class="owner-notice-form" novalidate>
            @csrf

            @if (session('success'))
                <div class="flash-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="owner-notice-form__group select-wrapper">
                <label class="owner-notice-form__label" for="target">宛先</label>
                <select name="target" id="target"  class="owner-notice-form__select">
                    <option value="">宛先を選択</option>
                    <option value="users" {{ old('target') === 'users' ? 'selected' : '' }}>全ユーザー</option>
                    <option value="reservations" {{ old('target') === 'reservations' ? 'selected' : '' }}>予約ユーザー</option>
                    <option value="likes" {{ old('target') === 'likes' ? 'selected' : '' }}>お気に入り登録ユーザー</option>
                    <option value="custom" {{ old('target') === 'custom' ? 'selected' : '' }}>手動指定</option>
                </select>
                <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
            </div>
            @error('target')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="owner-notice-form__group" id="custom-address-group" style="display: none;">
                <label class="owner-notice-form__label" for="emails">メールアドレス</label>
                <input type="text" name="emails" id="emails" class="owner-notice-form__input" placeholder="カンマ区切りで複数指定可">
                <div class="form-note">例）example1@rese.com, example2@rese.com</div>
            </div>
            @error('emails')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="owner-notice-form__group">
                <label class="owner-notice-form__label" for="subject">件名</label>
                <input type="text" name="subject" id="subject" class="owner-notice-form__input">
            </div>
            @error('subject')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="owner-notice-form__group">
                <label class="owner-notice-form__label" for="message">本文</label>
                <textarea name="message" id="message" rows="8" class="owner-notice-form__textarea"></textarea>
            </div>
            @error('message')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="owner-notice-form__btn">
                <button type="submit" class="owner-notice__btn--submit">送信する</button>
            </div>
        </form>
    </div>
</div>

{{-- 「手動指定」選択時にメールアドレス入力欄を表示 --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const target = document.getElementById('target');
        const customField = document.getElementById('custom-address-group');

        function toggleCustomField() {
            customField.style.display = target.value === 'custom' ? 'block' : 'none';
        }

        target.addEventListener('change', toggleCustomField);
        toggleCustomField();
    });
</script>
@endsection