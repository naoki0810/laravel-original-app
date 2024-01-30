<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '寿司', '居酒屋', 'イタリアン', 'ラーメン', 'カフェ',
            '和食', '日本料理', '海鮮・魚介', 'そば', 'うどん',
            'うなぎ', '焼き鳥', 'とんかつ', '串揚げ', '天ぷら',
            'お好み焼き', 'もんじゃ焼き', 'しゃぶしゃぶ', '沖縄料理', '洋食',
            'フレンチ', 'スペイン料理', 'パスタ', 'ビザ', 'ステーキ',
            'ハンバーグ', '中華料理', '餃子', '韓国料理', 'タイ料理',
            'カレー', 'ホルモン', '鍋', 'パン', 'スイーツ'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
    
}
