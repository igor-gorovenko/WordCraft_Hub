<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('words')->truncate();

        $words = [
            ['word' => 'apple', 'translation' => 'яблоко', 'usage_count' => rand(200, 1000)],
            ['word' => 'banana', 'translation' => 'банан', 'usage_count' => rand(200, 1000)],
            ['word' => 'cherry', 'translation' => 'вишня', 'usage_count' => rand(200, 1000)],
            ['word' => 'date', 'translation' => 'финик', 'usage_count' => rand(200, 1000)],
            ['word' => 'elderberry', 'translation' => 'бузина', 'usage_count' => rand(200, 1000)],
            ['word' => 'fig', 'translation' => 'инжир', 'usage_count' => rand(200, 1000)],
            ['word' => 'grape', 'translation' => 'виноград', 'usage_count' => rand(200, 1000)],
            ['word' => 'honeydew', 'translation' => 'дыня', 'usage_count' => rand(200, 1000)],
            ['word' => 'kiwi', 'translation' => 'киви', 'usage_count' => rand(200, 1000)],
            ['word' => 'lemon', 'translation' => 'лимон', 'usage_count' => rand(200, 1000)],
        ];

        DB::table('words')->insert($words);
    }
}
