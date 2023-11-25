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
        $selectedTags = $request->input('tags', []);

        // Если $selectedTags не является массивом, преобразуйте его в массив
        if (!is_array($selectedTags)) {
            $selectedTags = explode(',', $selectedTags);
        }

        $words = Word::with('tags')->get();

        // Формируем URL в зависимости от выбранных тегов
        $url = url('/');
        if (!empty($selectedTags)) {
            $url .= '?tags=' . implode(',', $selectedTags);
        }

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

        // Если теги не выбраны, просто получите все слова без фильтрации
        if (empty($selectedTags)) {
            $words = Word::with('tags')->get();
        }

        $tags = Tag::all();
    
        // Возвращаем только содержимое таблицы в формате JSON
        return response()->json(view('components.table', compact('words'))->render());
    }
}
