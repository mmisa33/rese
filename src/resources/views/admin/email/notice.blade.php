@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common/notice/form.css') }}">
@endsection

@section('content')
    @include('common.notice.form', [
        'role' => 'admin',
        'action' => route('admin.notice.send'),
        'back' => route('admin.index'),
        'oldTargets' => [
            'all' => '全登録ユーザー（管理者含む）',
            'owners' => '店舗代表者',
            'custom' => '手動指定',
        ],
    ])
@endsection