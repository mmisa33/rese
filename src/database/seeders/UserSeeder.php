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
        // 管理者
        User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 全ショップ取得
        $shops = Shop::all();

        foreach ($shops as $index => $shop) {
            // オーナー作成
            $owner = User::create([
                'name' => '店舗代表者' . ($index + 1),
                'email' => 'owner' . ($index + 1) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]);

            // オーナーをショップに紐付け
            $shop->owner_id = $owner->id;
            $shop->save();
        }
    }
}
