<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => 'Fruit']);
        Tag::create(['name' => 'Vegetable']);
        Tag::create(['name' => 'Product']);
        Tag::create(['name' => 'House']);
        Tag::create(['name' => 'Car']);
    }
}
