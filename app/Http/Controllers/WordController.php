<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Tag;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        $tags = Tag::all();
        return view('index', compact('words', 'tags'));
    }

    public function show($id)
    {
        $word = Word::findOrFail($id);
        return view('show', compact('word'));
    }
}
