<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartOfSpeechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('parts_of_speech')->truncate();

        $parts_of_speech = [
            ['name' => 'noun'],
            ['name' => 'verb'],
            ['name' => 'adverb'],
            ['name' => 'conjunction'],
            ['name' => 'preposition'],
            ['name' => 'particle'],
            ['name' => 'pronoun'],
        ];

        DB::table('parts_of_speech')->insert($parts_of_speech);
    }
}
