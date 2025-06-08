<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            '東京都',
            '大阪府',
            '福岡県',
        ];

        foreach ($areas as $area) {
            Area::create(['name' => $area]);
        }
    }
}