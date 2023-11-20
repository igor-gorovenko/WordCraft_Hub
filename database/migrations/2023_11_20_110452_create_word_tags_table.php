<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('word_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('word_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_tags');
    }
};
