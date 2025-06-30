<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 一般ユーザー3名
        User::create([
            'name' => '山田太郎',
            'email' => 'user1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => '佐藤花子',
            'email' => 'user2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => '鈴木次郎',
            'email' => 'user3@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // 管理者
        User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 全店舗を取得
        $shops = Shop::all();

        foreach ($shops as $index => $shop) {
            // 店舗代表者作成
            $owner = User::create([
                'name' => '店舗代表者' . ($index + 1),
                'email' => 'owner' . ($index + 1) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]);

            // 店舗代表者を店舗に紐付け
            $shop->owner_id = $owner->id;
            $shop->save();
        }
    }
}
