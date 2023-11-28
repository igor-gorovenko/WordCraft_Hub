<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Tag;

class WordController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();
        $selectedTags = $this->normalizeTagsInput($request->input('tags'));

        $query = Word::with('tags');

        if (!empty($selectedTags)) {
            $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('name', $selectedTags));
        }

        $words = $query->get();

        $url = url('/');

        // Добавляем временную метку к параметру tags
        if (!empty($selectedTags)) {
            $url .= '?tags=' . implode(',', $selectedTags);
        }

        return view('index', compact('words', 'tags', 'selectedTags', 'url'));
    }



    public function show($id)
    {
        $word = Word::find($id);

        abort_if(!$word, 404);

        return view('show', compact('word'));
    }


    public function filter(Request $request)
    {
        $selectedTags = $this->normalizeTagsInput($request->input('tags'));

        $query = Word::with('tags')->when($selectedTags, function ($query) use ($selectedTags) {
            $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('name', $selectedTags));
        });

        $words = $query->get();
        $tags = Tag::all();

        return response()->json(view('components.table', compact('words'))->render());
    }


    public function export(Request $request)
    {
        $query = Word::query();

        $words = $query->get();

        $csvData = "Word,Translation\n";

        foreach ($words as $word) {
            $csvData .= sprintf(
                "%s,%s\n",
                $word->word,
                $word->translation
            );
        }

        $filename = 'words' . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }



    protected function normalizeTagsInput($input)
    {
        return is_array($input) ? $input : (empty($input) ? [] : explode(',', $input));
    }
}
