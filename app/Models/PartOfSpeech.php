<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartOfSpeech extends Model
{
    use HasFactory;

    protected $table = 'parts_of_speech';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function words()
    {
        return $this->hasMany(Word::class, 'part_of_speech_id');
    }
}
