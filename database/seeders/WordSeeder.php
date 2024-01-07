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
            ['word' => 'apple', 'translate' => 'яблоко', 'frequency' => 22.03],
            ['word' => 'banana', 'translate' => 'банан', 'frequency' => 9.45],
            ['word' => 'cherry', 'translate' => 'вишня', 'frequency' => 12.25],
            ['word' => 'elderberry', 'translate' => 'бузина', 'frequency' => 0.05],
            ['word' => 'fig', 'translate' => 'инжир', 'frequency' => 1.53],
            ['word' => 'grape', 'translate' => 'виноград', 'frequency' => 2.99],
            ['word' => 'honeydew', 'translate' => 'дыня', 'frequency' => 0.13],
            ['word' => 'kiwi', 'translate' => 'киви', 'frequency' => 0.89],
            ['word' => 'lemon', 'translate' => 'лимон', 'frequency' => 9.92],
        ];

        DB::table('words')->insert($words);
    }
}
