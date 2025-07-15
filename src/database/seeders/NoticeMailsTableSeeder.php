<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class NoticeMailsTableSeeder extends Seeder
{
    public function run(): void
    {
        // 管理者ユーザーを取得
        $admin = User::where('role', 'admin')->first();
        // 店舗代表者を 1人取得
        $owner = User::where('role', 'owner')->first();

        // 安全確認
        if (!$admin || !$owner) {
            $this->command->warn('Admin または Owner ユーザーが見つかりません。Seeder を先に実行してください。');
            return;
        }

        $now = now();

        DB::table('notice_mails')->insert([
            // ---------- 管理者から全ユーザーへ ----------
            [
                'user_id'       => $admin->id,
                'target'        => 'all',
                'custom_emails' => null,
                'subject'       => '【Rese】システムメンテナンスのお知らせ',
                'message'       => "いつもご利用ありがとうございます。\n下記日時にメンテナンスを行います。\n日時：2025/07/15 00:00–06:00",
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            // ---------- 管理者から店舗代表者へ ----------
            [
                'user_id'       => $admin->id,
                'target'        => 'owners',
                'custom_emails' => null,
                'subject'       => '【Rese】予約管理機能アップデート',
                'message'       => "店舗代表者各位\n新しい予約管理画面を追加しましたのでお試しください。",
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            // ---------- 店舗代表者から予約ユーザーへ ----------
            [
                'user_id'       => $owner->id,
                'target'        => 'reservations',
                'custom_emails' => null,
                'subject'       => '【○○店】夏季限定メニュー開始！',
                'message'       => "いつもご予約ありがとうございます。\n本日より夏の限定メニューを開始しました！",
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            // ---------- 店舗代表者からカスタムユーザーへ ----------
            [
                'user_id'       => $owner->id,
                'target'        => 'custom',
                'custom_emails' => "vip1@example.com, vip2@example.com",
                'subject'       => '【限定】VIP 会員様ご優待のご案内',
                'message'       => "日頃のご愛顧に感謝し、特別コースをご用意いたしました。",
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);
    }
}