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


    public function filterTags(Request $request)
    {
        $selectedTags = $request->input('tags', []);
    
        $words = Word::with('tags')
            ->when(count($selectedTags) > 0, function ($query) use ($selectedTags) {
                $query->whereHas('tags', function ($tagQuery) use ($selectedTags) {
                    $tagQuery->whereIn('name', $selectedTags);
                });
            })
            ->get();
    
        $tags = Tag::all();
    
        // Возвращаем только содержимое таблицы в формате JSON
        return response()->json(view('components.table', compact('words'))->render());
    }
}
