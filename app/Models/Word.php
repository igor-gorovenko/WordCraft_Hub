<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PartOfSpeech;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'word',
        'part_of_speech_id',
        'translate',
        'frequency',
        'slug',
    ];

    public function partOfSpeech()
    {
        return $this->belongsTo(PartOfSpeech::class, 'part_of_speech_id');
    }
}
