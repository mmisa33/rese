<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Like;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 一般ユーザー3名作成
        $user1 = User::create([
            'name' => '田中太郎',
            'email' => 'tanaka@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => '山田花子',
            'email' => 'yamada@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $user3 = User::create([
            'name' => '佐藤次郎',
            'email' => 'sato@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // 店舗を6件取得
        $shopIds = Shop::pluck('id')->take(6)->values();

        // Likes（user1が5店舗にいいね）
        foreach ($shopIds->slice(0, 5) as $shopId) {
            Like::create([
                'user_id' => $user1->id,
                'shop_id' => $shopId,
            ]);
        }

        // Reservations
        $reservations = [];

        // 過去の予約（レビュー済み）
        $reservations[] = Reservation::create([
            'user_id' => $user1->id,
            'shop_id' => $shopIds[0],
            'date' => now()->subDays(5)->toDateString(),
            'time' => '18:00',
            'number' => 2,
        ]);

        // 過去の予約（未レビュー）
        $reservations[] = Reservation::create([
            'user_id' => $user1->id,
            'shop_id' => $shopIds[1],
            'date' => now()->subDays(3)->toDateString(),
            'time' => '19:00',
            'number' => 3,
        ]);

        // 未来の予約3件（レビュー不可）
        $reservations[] = Reservation::create([
            'user_id' => $user1->id,
            'shop_id' => $shopIds[2],
            'date' => now()->addDays(3)->toDateString(),
            'time' => '18:30',
            'number' => 2,
        ]);
        $reservations[] = Reservation::create([
            'user_id' => $user1->id,
            'shop_id' => $shopIds[3],
            'date' => now()->addDays(5)->toDateString(),
            'time' => '19:00',
            'number' => 1,
        ]);
        $reservations[] = Reservation::create([
            'user_id' => $user1->id,
            'shop_id' => $shopIds[4],
            'date' => now()->addDays(7)->toDateString(),
            'time' => '20:00',
            'number' => 4,
        ]);

        // レビュー（1件のみ過去予約に紐付け）
        Review::create([
            'user_id' => $user1->id,
            'reservation_id' => $reservations[0]->id,
            'rating' => 5,
            'comment' => 'とても美味しく、サービスも良かったです！',
        ]);
    }
}