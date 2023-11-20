<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'translation',
        'usage_count',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'word_tags');
    }
}
