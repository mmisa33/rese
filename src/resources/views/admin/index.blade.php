@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common/notice/list.css') }}">
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
                    <ul>
                        @foreach ($owners as $owner)
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
                    </ul>

                    <div class="pagination">
                        {{ $owners->appends(request()->except('owners_page'))->links() }}
                    </div>
                </div>
            </div>

            {{-- お知らせメール一覧 --}}
            @include('common.notice.list', [
                'title' => 'お知らせメール',
                'createRoute' => route('admin.notice.form'),
                'showRoute' => 'admin.notice.show',
                'notices' => $notices,
            ])
        </div>
    </div>
@endsection
