<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\PartOfSpeech;

class WordPartOfSpeechTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = Word::all();
        $partsOfSpeech = PartOfSpeech::all();

        foreach ($words as $word) {
            $numberOfParts = mt_rand(1, 3);
            $selectedParts = $partsOfSpeech->random($numberOfParts);

            $word->partsOfSpeech()->attach($selectedParts->pluck('id')->toArray());
        }
    }
}
