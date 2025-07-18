<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreasTableSeeder::class,
            GenresTableSeeder::class,
            ShopsTableSeeder::class,
            AdminSeeder::class,
            OwnerSeeder::class,
            UserSeeder::class,
            NoticeMailsTableSeeder::class,
        ]);
    }
}
