<?php

namespace App\Http\Controllers;

use App\Models\Word;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        return view('index', compact('words'));
    }

    public function show($id)
    {
        $word = Word::findOrFail($id);
        return view('show', compact('word'));
    }
}
