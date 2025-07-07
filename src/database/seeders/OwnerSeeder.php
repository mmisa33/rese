<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        // 全店舗取得
        $shops = Shop::all();

        foreach ($shops as $index => $shop) {
            // 店舗代表者ユーザー作成
            $owner = User::create([
                'name' => '店舗代表者' . ($index + 1),
                'email' => 'owner' . ($index + 1) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]);

            // 店舗にowner_id紐付けて保存
            $shop->owner_id = $owner->id;
            $shop->save();
        }
    }
}