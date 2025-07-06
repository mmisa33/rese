<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeMailRequest;
use App\Models\User;
use App\Models\NoticeMail;
use App\Mail\NoticeMail as NoticeMailable;

class NoticeMailController extends Controller
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

        // 全一般ユーザー
        if ($request->target === 'users') {
            $emails = User::where('role', 'user')->pluck('email')->toArray();

        // 予約ユーザー
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

        // お気に入り登録ユーザー
        } elseif ($request->target === 'likes') {
            $shop = $owner->shop;
            if ($shop) {
                $emails = $shop->likedByUsers()
                    ->pluck('email')
                    ->unique()
                    ->toArray();
            }

        // 手動指定
        } elseif ($request->target === 'custom') {
            $emails = array_map('trim', explode(',', $request->emails));
        }

        // メール送信
        if (empty($emails)) {
            return back()->withErrors('送信対象のメールアドレスが見つかりません。');
        }

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new NoticeMailable($request->subject, $request->message));
            }
        } catch (\Throwable $e) {
            // ログ出力などエラーハンドリング
            Log::error($e);
            return back()->withErrors('メール送信中にエラーが発生しました。');
        }

        NoticeMail::create([
            'user_id' => $owner->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'target'  => $request->target,
            'custom_emails' => $request->target === 'custom' ? $request->emails : null,
        ]);

        return redirect()->route('owner.notice.form')->with('success', 'メールを送信しました');
    }

    // お知らせメール送詳細ページを表示
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