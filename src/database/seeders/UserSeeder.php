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
        $shops = Shop::all();

        // 管理者
        User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 店舗代表者
        $owner1 = User::create([
            'name' => '店舗代表者1',
            'email' => 'owner1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $owner2 = User::create([
            'name' => '店舗代表者2',
            'email' => 'owner2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // Shop側にオーナーを紐付け
        $shops[0]->owner_id = $owner1->id;
        $shops[0]->save();

        $shops[1]->owner_id = $owner2->id;
        $shops[1]->save();
    }
}
