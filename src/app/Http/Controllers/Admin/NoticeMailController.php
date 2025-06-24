<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeMailRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\NoticeMail;
use App\Mail\NoticeMail as NoticeMailable;

class NoticeMailController extends Controller
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

        foreach ($emails as $email) {
            Mail::to($email)->send(new NoticeMailable($request->subject, $request->message));
        }

        NoticeMail::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'target'  => $request->target,
        ]);

        return redirect()->route('admin.notice.form')->with('success', 'メールを送信しました');
    }

    // お知らせメール送詳細ページを表示
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