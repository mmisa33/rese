@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/notice.css') }}">
@endsection

@section('content')
<div class="admin-notice">
    <h2 class="admin-notice__header">お知らせメール送信</h2>

    <form method="POST" action="{{ route('admin.notice.send') }}" class="admin-notice__form">
        @csrf

        <div class="form-group">
            <label for="subject">件名</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="message">本文</label>
            <textarea name="message" id="message" rows="8" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">送信する</button>
    </form>
</div>
@endsection