@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common/notice/form.css') }}">
@endsection

@section('content')
    @include('common.notice.form', [
        'role' => 'owner',
        'action' => route('owner.notice.send'),
        'back' => route('owner.index'),
        'oldTargets' => [
            'users' => '全ユーザー',
            'reservations' => '予約ユーザー',
            'likes' => 'お気に入り登録ユーザー',
            'custom' => '手動指定',
        ],
    ])
@endsection
