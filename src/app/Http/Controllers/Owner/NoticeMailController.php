<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Shared\BaseNoticeMailController;
use App\Http\Requests\NoticeMailRequest;
use App\Models\User;
use App\Models\NoticeMail;

class NoticeMailController extends BaseNoticeMailController
{
    // お知らせメール送信ページを表示
    public function showNoticeForm()
    {
        return view('owner.email.notice');
    }

    // お知らせメール送信機能
    public function sendNotice(NoticeMailRequest $request)
    {
        $owner = auth()->user();
        $emails = [];

        if ($request->target === 'users') {
            $emails = User::where('role', 'user')->pluck('email')->toArray();
        } elseif ($request->target === 'reservations') {
            $shop = $owner->shop;
            if ($shop) {
                $emails = $shop->reservations()
                    ->with('user')
                    ->get()
                    ->pluck('user.email')
                    ->unique()
                    ->toArray();
            }
        } elseif ($request->target === 'likes') {
            $shop = $owner->shop;
            if ($shop) {
                $emails = $shop->likedByUsers()
                    ->get()
                    ->pluck('email')
                    ->unique()
                    ->toArray();
            }
        } elseif ($request->target === 'custom') {
            $emails = array_map('trim', explode(',', $request->emails));
        }

        $error = $this->sendEmails($emails, $request->subject, $request->message);
        if ($error) return $error;

        $this->createNoticeMail($owner->id, $request);

        return redirect()->route('owner.notice.form')->with('success', 'メールを送信しました');
    }

    // お知らせメール詳細ページを表示
    public function showNotice($id)
    {
        $notice = NoticeMail::findOrFail($id);

        $targets = [
            'users'        => '全ユーザー',
            'reservations' => '予約ユーザー',
            'likes'        => 'お気に入り登録ユーザー',
            'custom'       => '手動指定',
        ];

        return view('owner.email.detail', compact('notice', 'targets'));
    }
}