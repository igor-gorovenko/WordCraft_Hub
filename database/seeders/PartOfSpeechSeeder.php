<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartOfSpeechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parts_of_speech')->delete();

        $names = ['noun', 'verb', 'adverb', 'adjective', 'conjunction', 'preposition', 'particle', 'pronoun'];

        $parts_of_speech = [];

        foreach ($names as $name) {
            $slug = Str::slug($name, '-');

            $parts_of_speech[] = ['name' => $name, 'slug' => $slug];
        }

        DB::table('parts_of_speech')->insert($parts_of_speech);
    }
}
