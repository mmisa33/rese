@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/email/notice.css') }}">
@endsection

@section('content')
<div class="admin-notice">
    <div class="admin-notice__title">
        <a href="{{ route('admin.index') }}" class="back-btn">&lt;</a>
        <h2>お知らせメール送信</h2>
    </div>

    <div class="admin-notice__content">
        <form method="POST" action="{{ route('admin.notice.send') }}" class="admin-notice-form" novalidate>
            @csrf

            @if (session('success'))
                <div class="flash-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="admin-notice-form__group select-wrapper">
                <label class="admin-notice-form__label" for="target">宛先</label>
                <select name="target" id="target"  class="admin-notice-form__select">
                    <option value="">宛先を選択</option>
                    <option value="all" {{ old('target') === 'all' ? 'selected' : '' }}>全ユーザー</option>
                    <option value="owners" {{ old('target') === 'owners' ? 'selected' : '' }}>店舗代表者</option>
                    <option value="custom" {{ old('target') === 'custom' ? 'selected' : '' }}>手動指定</option>
                </select>
                <img src="{{ asset('images/icon/select.png') }}" alt="Select Icon" class="select-icon">
            </div>
            @error('target')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="admin-notice-form__group" id="custom-address-group" style="display: none;">
                <label class="admin-notice-form__label" for="emails">メールアドレス</label>
                <input type="text" name="emails" id="emails" class="admin-notice-form__input" placeholder="カンマ区切りで複数指定可">
                <div class="form-note">例）example1@rese.com, example2@rese.com</div>
            </div>
            @error('emails')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="admin-notice-form__group">
                <label class="admin-notice-form__label" for="subject">件名</label>
                <input type="text" name="subject" id="subject" class="admin-notice-form__input">
            </div>
            @error('subject')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="admin-notice-form__group">
                <label class="admin-notice-form__label" for="message">本文</label>
                <textarea name="message" id="message" rows="8" class="admin-notice-form__textarea"></textarea>
            </div>
            @error('message')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="admin-notice-form__btn">
                <button type="submit" class="admin-notice__btn--submit">送信する</button>
            </div>
        </form>
    </div>
</div>

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