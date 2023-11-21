<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Tag;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        $tags = Tag::all();
        $selectedTags = [];
        return view('index', compact('words', 'tags', 'selectedTags'));
    }

    public function show($id)
    {
        $word = Word::findOrFail($id);
        return view('show', compact('word'));
    }

    public function filterTags(Request $request)
    {
        $tags = Tag::all();
        $selectedTags = $request->input('tags');

        $filteredTags = Word::whereHas('tags', function ($query) use ($selectedTags) {
            $query->whereIn('name', $selectedTags);
        })->get();

        return view('index', compact('filteredTags', 'tags', 'selectedTags'));
    }
}
