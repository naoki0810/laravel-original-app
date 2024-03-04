<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'category_id' => '1',
            'name' => '佐藤',
            'description' => 'さとう',
            'min_price' => '5000',
            'max_price' => '7000',
            'opening_time' => '11:00:00',
            'closing_time' => '22:00:00',
            'regular_holiday' => 'Sunday',
            'postal_code' => '1234567',
            'address' => '東京都渋谷区1-1-1',
        ]);
    }
}
