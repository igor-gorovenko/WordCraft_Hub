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
        // Преобразуем в массив, если это строка
        $selectedTags = is_array($selectedTags) ? $selectedTags : [$selectedTags];

        $query = Word::with('tags');

        if (!empty($selectedTags)) {
            $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('name', $selectedTags));
        }

        $words = $query->get();


        $url = !empty($selectedTags) ? '?tags=' . implode(',', $selectedTags) : '';


        return view('site.index', compact('words', 'tags', 'selectedTags', 'url'));
    }


    public function filter(Request $request)
    {
        $selectedTags = $request->input('tags', []);



        if (empty($selectedTags)) {
            return redirect()->route('index');
        }

        $query = Word::with('tags')->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('name', $selectedTags));
        $words = $query->get();
        $tags = Tag::all();

        return response()->json(view('components.table', compact('words'))->render());
    }

    public function export(Request $request)
    {
        $selectedTags = $request->input('tags', []);

        $query = Word::query();

        if (!empty($selectedTags)) {
            $query->whereHas('tags', fn ($tagQuery) => $tagQuery->whereIn('name', $selectedTags));
        }

        $words = $query->with(['tags' => function ($tagQuery) use ($selectedTags) {
            // Добавляем фильтр для выбранных тегов в предварительной загрузке
            if (!empty($selectedTags)) {
                $tagQuery->whereIn('name', $selectedTags);
            }
        }])
            ->orderBy('usage_count', 'desc')
            ->get();

        $csvData = "Number,Word,Translation,Usage Count,Usage %,Tags\n";
        $count = 0;

        foreach ($words as $word) {
            // Используем метод pluck, чтобы получить массив имен тегов
            $tags = $word->tags->pluck('name')->implode(',');

            // Обертываем теги в двойные кавычки
            $tags = str_replace(',', ', ', $tags);
            $tags = '"' . str_replace('"', '""', $tags) . '"';

            $count++;

            $csvData .= sprintf(
                "%s,%s,%s,%s,%s,%s\n",
                $count,
                $word->word,
                $word->translation,
                $word->usage_count,
                number_format(($word->usage_count / count($words)) / 100, 2, '.', ''),
                $tags
            );
        }

        $filename = 'words' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
