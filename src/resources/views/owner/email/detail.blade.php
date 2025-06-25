@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/owner/email/detail.css') }}">
@endsection

@section('content')
<div class="owner-notice-detail">
    <div class="owner-notice-detail__title">
        <a href="{{ route('owner.index') }}" class="back-btn">&lt;</a>
        <h2 class="owner-notice-detail__header">お知らせ詳細</h2>
    </div>

    <div class="owner-notice-detail__content">
        <div class="owner-notice-detail__info">
            <div class="owner-notice-detail__item">
                <div class="owner-notice-detail__label">送信日</div>
                <div class="owner-notice-detail__value">{{ $notice->created_at->format('Y/m/d H:i') }}</div>
            </div>
            <div class="owner-notice-detail__item">
                <div class="owner-notice-detail__label">送付先</div>
                <div class="owner-notice-detail__value">
                    {{ $targets[$notice->target] ?? '不明' }}
                    @if ($notice->target === 'custom' && $notice->custom_emails)
                        <br><small>{{ $notice->custom_emails }}</small>
                    @endif
                </div>
            </div>
            <div class="owner-notice-detail__item">
                <div class="owner-notice-detail__label">件名</div>
                <div class="owner-notice-detail__value">{{ $notice->subject }}</div>
            </div>
            <div class="owner-notice-detail__item">
                <div class="owner-notice-detail__label">本文</div>
                <div class="owner-notice-detail__value">
                    {!! nl2br(e($notice->message)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection