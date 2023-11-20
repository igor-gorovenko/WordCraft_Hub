<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Word;
use App\Models\Tag;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Word::query()->delete();

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
            ['word' => 'carrot', 'translation' => 'морковь', 'usage_count' => rand(200, 1000)],
            ['word' => 'tomato', 'translation' => 'помидор', 'usage_count' => rand(200, 1000)],
            ['word' => 'broccoli', 'translation' => 'брокколи', 'usage_count' => rand(200, 1000)],
            ['word' => 'potato', 'translation' => 'картошка', 'usage_count' => rand(200, 1000)],
            ['word' => 'cucumber', 'translation' => 'огурец', 'usage_count' => rand(200, 1000)],
            ['word' => 'house', 'translation' => 'дом', 'usage_count' => rand(200, 1000)],
            ['word' => 'apartment', 'translation' => 'квартира', 'usage_count' => rand(200, 1000)],
            ['word' => 'room', 'translation' => 'комната', 'usage_count' => rand(200, 1000)],
            ['word' => 'kitchen', 'translation' => 'кухня', 'usage_count' => rand(200, 1000)],
            ['word' => 'bedroom', 'translation' => 'спальня', 'usage_count' => rand(200, 1000)],
            ['word' => 'car', 'translation' => 'автомобиль', 'usage_count' => rand(200, 1000)],
            ['word' => 'truck', 'translation' => 'грузовик', 'usage_count' => rand(200, 1000)],
            ['word' => 'van', 'translation' => 'фургон', 'usage_count' => rand(200, 1000)],
            ['word' => 'motorcycle', 'translation' => 'мотоцикл', 'usage_count' => rand(200, 1000)],
            ['word' => 'bicycle', 'translation' => 'велосипед', 'usage_count' => rand(200, 1000)],
        ];

        // Add words
        DB::table('words')->insert($words);
    }
}
