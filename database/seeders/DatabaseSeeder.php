<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PartOfSpeechSeeder::class);
        $this->call(WordSeeder::class);
        $this->call(WordPartOfSpeechTableSeeder::class);
    }
}
