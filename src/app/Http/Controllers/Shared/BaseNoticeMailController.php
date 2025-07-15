<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeMailRequest;
use App\Mail\NoticeMail as NoticeMailable;
use App\Models\NoticeMail;

abstract class BaseNoticeMailController extends Controller
{
    // 複数アドレスへお知らせメール送信処理(管理者・店舗代表者共通)
    protected function sendEmails(array $emails, string $subject, string $message)
    {
        if (empty($emails)) {
            return back()->withErrors(['send_error' => '送信対象のメールアドレスが見つかりません']);
        }

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new NoticeMailable($subject, $message));
            }
        } catch (\Throwable $e) {
            Log::error($e);
            return back()->withErrors(['send_error' => 'メール送信中にエラーが発生しました']);
        }

        return null; // success
    }

    // お知らせメールDB保存処理(管理者・店舗代表者共通)
    protected function createNoticeMail(int $userId, NoticeMailRequest $request)
    {
        NoticeMail::create([
            'user_id' => $userId,
            'subject' => $request->subject,
            'message' => $request->message,
            'target'  => $request->target,
            'custom_emails' => $request->target === 'custom' ? $request->emails : null,
        ]);
    }
}