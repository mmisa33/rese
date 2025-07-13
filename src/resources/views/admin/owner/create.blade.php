@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/owner/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common/auth/form.css') }}">
@endsection

@section('content')
    <div class="owner-create">
        <div class="page-title">
            <a href="{{ route('admin.index') }}" class="back-btn">&lt;</a>
            <h2>店舗代表者アカウント作成</h2>
        </div>

        {{-- 店舗代表者作成フォーム --}}
        <div class="auth-form__owner">
            @include('common.auth.form', [
                'route' => 'admin.owner.store',
                'headerText' => 'Create Owner Account',
                'namePlaceholder' => 'Owner name',
                'buttonText' => '作成',
                'hasName' => true,
            ])
        </div>
    </div>
@endsection
