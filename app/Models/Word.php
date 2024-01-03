<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PartOfSpeech;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'translate',
        'usage_count',
    ];

    public function partsOfSpeech()
    {
        return $this->belongsToMany(PartOfSpeech::class, 'word_part_of_speech', 'word_id', 'part_of_speech_id');
    }
}
