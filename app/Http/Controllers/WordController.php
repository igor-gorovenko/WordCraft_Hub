<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Tag;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::with('tags')->get();
        $tags = Tag::all();
        $selectedTags = [];
        return view('index', compact('words', 'tags', 'selectedTags'));
    }

    public function show($id)
    {
        $word = Word::find($id);
        if (!$word) {
            abort(404);
        }
        return view('show', compact('word'));
    }

    public function filter(Request $request)
    {
        $tags = Tag::all();

        // Получаем параметры из URL
        $selectedTags = $request->input('tags', []);
        $filteredTags = [];

        if (!empty($selectedTags)) {
            $filteredTags = Word::whereHas('tags', function ($query) use ($selectedTags) {
                $query->whereIn('name', $selectedTags);
            })->get();
        } else {
            $filteredTags = Word::all();
        }

        return view('index', compact('filteredTags', 'tags', 'selectedTags'));
    }
}
