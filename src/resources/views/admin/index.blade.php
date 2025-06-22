@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('content')
<div class="admin-home">

    {{-- ヘッダー --}}
    <h2 class="admin-home__header">管理者メニュー</h2>

    <div class="admin-home__container">

        {{-- <div class="admin-section">
            <h2>システム情報</h2>
            <ul>
                <li>登録ユーザー数: {{ $userCount }}</li>
            </ul>
        </div> --}}

        {{-- 店舗代表者一覧 --}}
        <div class="owner-list">
            <h3 class="owner-list__title">店舗代表者一覧</h3>
            <div class="owner-list__section">
                <div class="owner-list__create-btn">
                    <a href="{{ route('admin.owner.create') }}" class="create-btn">新規作成</a>
                </div>
                @foreach($owners as $owner)
                    <li class="owner-list__list">
                        <a href="{{ route('admin.owner.show', $owner->id) }}" class="owner-list__link">
                            <div class="owner-list__name"><img src="{{ asset('images/icon/user.png') }}" alt="User Icon" class="icon">{{ $owner->name }}</div>
                            <div class="owner-list__email">（{{ $owner->email }}）</div>
                        </a>
                    </li>
                @endforeach
            </div>
        </div>

        {{-- お知らせメール一覧 --}}
        <div class="notice-mail">
            <h3 class="notice-mail__title">お知らせメール</h3>
            <div class="notice-mail__section">
                <a href="{{ route('admin.notice.form') }}" class="create-btn\
                
                ">お知らせを送信する</a>

                @if ($notices->isNotEmpty())
                    <ul class="notice-mail__list">
                        @foreach ($notices as $notice)
                            <li class="notice-mail__item">
                                <span class="notice-mail__date">{{ $notice->created_at->format('Y/m/d') }}</span>
                                <span class="notice-mail__subject">{{ $notice->subject }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="notice-mail__empty">まだお知らせは送信されていません。</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
