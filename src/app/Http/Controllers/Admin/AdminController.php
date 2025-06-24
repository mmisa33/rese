<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeMailRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\NoticeMail;
use App\Mail\NoticeMail as NoticeMailable;

class AdminController extends Controller
{
    public function index()
    {
        // 店舗代表者を取得
        $owners = User::where('role', 'owner')->with('shop')->paginate(15);

        // お知らせメール一覧
        $notices = NoticeMail::latest()->take(10)->get();

        return view('admin.index', compact( 'owners', 'notices'));
    }

    public function showNoticeForm()
    {
        return view('admin.email.notice');
    }

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

    public function showNotice(NoticeMail $notice)
    {
        return view('admin.email.notice_show', compact('notice'));
    }
}