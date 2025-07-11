@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shared/notice/form.css') }}">
@endsection

@section('content')
@include('shared.notice.form', [
    'role' => 'admin',
    'action' => route('admin.notice.send'),
    'back' => route('admin.index'),
    'oldTargets' => [
        'all' => '全ユーザー',
        'owners' => '店舗代表者',
        'custom' => '手動指定'
    ]
])
@endsection