<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('words')->delete();

        $words = [
            ['word' => 'apple', 'translate' => 'яблоко', 'usage_count' => rand(200, 1000)],
            ['word' => 'banana', 'translate' => 'банан', 'usage_count' => rand(200, 1000)],
            ['word' => 'cherry', 'translate' => 'вишня', 'usage_count' => rand(200, 1000)],
            ['word' => 'date', 'translate' => 'финик', 'usage_count' => rand(200, 1000)],
            ['word' => 'elderberry', 'translate' => 'бузина', 'usage_count' => rand(200, 1000)],
            ['word' => 'fig', 'translate' => 'инжир', 'usage_count' => rand(200, 1000)],
            ['word' => 'grape', 'translate' => 'виноград', 'usage_count' => rand(200, 1000)],
            ['word' => 'honeydew', 'translate' => 'дыня', 'usage_count' => rand(200, 1000)],
            ['word' => 'kiwi', 'translate' => 'киви', 'usage_count' => rand(200, 1000)],
            ['word' => 'lemon', 'translate' => 'лимон', 'usage_count' => rand(200, 1000)],
        ];

        DB::table('words')->insert($words);
    }
}
