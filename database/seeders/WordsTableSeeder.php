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
            ['word' => 'apple', 'translation' => 'яблоко'],
            ['word' => 'banana', 'translation' => 'банан'],
            ['word' => 'cherry', 'translation' => 'вишня'],
            ['word' => 'date', 'translation' => 'финик'],
            ['word' => 'elderberry', 'translation' => 'бузина'],
            ['word' => 'fig', 'translation' => 'инжир'],
            ['word' => 'grape', 'translation' => 'виноград'],
            ['word' => 'honeydew', 'translation' => 'дыня'],
            ['word' => 'kiwi', 'translation' => 'киви'],
            ['word' => 'lemon', 'translation' => 'лимон'],
        ];

        DB::table('words')->insert($words);
    }
}
