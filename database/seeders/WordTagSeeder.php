<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Tag;


class WordTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = Word::all();
        $tags = Tag::all();

        foreach ($words as $word) {
            $tagsToAttach = $tags->random(rand(1, 3));
            $word->tags()->attach($tagsToAttach);
        }
    }
}
