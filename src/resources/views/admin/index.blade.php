@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('content')
<div class="admin-home">

    {{-- ヘッダー --}}
    <h2 class="admin-home__header">管理者メニュー</h2>

    <div class="admin-home__container">
        {{-- 店舗代表者一覧 --}}
        <div class="owner-list">
            <h3 class="owner-list__title">店舗代表者一覧</h3>

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
            <div class="flash-message">
                {{ session('status') }}
            </div>
            @endif

            <div class="owner-list__section">
                <div class="owner-list__create-btn">
                    <a href="{{ route('admin.owner.create') }}" class="create-btn">新規作成</a>
                </div>
                @foreach($owners as $owner)
                    <li class="owner-list__list">
                        <a href="{{ route('admin.owner.show', $owner->id) }}" class="owner-list__link">
                            <div class="owner-list__row">
                                <div class="owner-list__name">
                                    <img src="{{ asset('images/icon/user.png') }}" alt="User Icon" class="icon">
                                    {{ $owner->name }}
                                </div>
                                <div class="owner-list__email">（{{ $owner->email }}）</div>
                            </div>
                        </a>
                    </li>
                @endforeach

                <div class="pagination">
                    {{ $owners->links() }}
                </div>
            </div>
        </div>

        {{-- お知らせメール一覧 --}}
        <div class="notice-mail">
            <h3 class="notice-mail__title">お知らせメール</h3>
            <div class="notice-mail__section">
                <div class="notice-mail__submit-btn">
                    <a href="{{ route('admin.notice.form') }}" class="submit-btn">新規作成</a>
                </div>

                @if ($notices->isNotEmpty())
                    <ul class="notice-mail__list">
                        @foreach ($notices as $notice)
                            <li class="notice-mail__item">
                                <a href="{{ route('admin.notice.show', $notice->id) }}" class="notice-mail__link">
                                    <div class="notice-mail__row">
                                        <div class="notice-mail__date">
                                            <img src="{{ asset('images/icon/email.png') }}" alt="Email Icon" class="icon">
                                            {{ $notice->created_at->format('Y/m/d H:i') }}
                                        </div>
                                        <div class="notice-mail__subject">{{ $notice->subject }}</div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="notice-mail__empty">お知らせは送信されていません</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
