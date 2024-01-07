<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    public function create(Request $request)
    {
        return view('site.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        $word = new Word([
            'word' => $request->input('word'),
            'translate' => 'test',
            'usage_count' => 100,
        ]);

        $word->save();

        return redirect()->route('index')->with('success', 'Create new words');
    }
}
