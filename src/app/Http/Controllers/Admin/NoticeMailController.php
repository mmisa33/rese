<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Shared\BaseNoticeMailController;
use App\Http\Requests\NoticeMailRequest;
use App\Models\User;
use App\Models\NoticeMail;

class NoticeMailController extends BaseNoticeMailController
{
    // お知らせメール送信ページを表示
    public function showNoticeForm()
    {
        return view('admin.email.notice');
    }

    // お知らせメール送信機能
    public function sendNotice(NoticeMailRequest $request)
    {
        $emails = [];

        if ($request->target === 'all') {
            $emails = User::pluck('email')->toArray();
        } elseif ($request->target === 'owners') {
            $emails = User::where('role', 'owner')->pluck('email')->toArray();
        } elseif ($request->target === 'custom') {
            $emails = array_map('trim', explode(',', $request->emails));
        }

        $error = $this->sendEmails($emails, $request->subject, $request->message);
        if ($error) return $error;

        $this->createNoticeMail(Auth::id(), $request);

        return redirect()->route('admin.notice.form')->with('success', 'メールを送信しました');
    }

    // お知らせメール詳細ページを表示
    public function showNotice($id)
    {
        $notice = NoticeMail::findOrFail($id);

        $targets = [
            'all' => '全ユーザー',
            'owners' => '店舗代表者',
            'custom' => '手動指定',
        ];

        return view('admin.email.detail', compact('notice', 'targets'));
    }
}