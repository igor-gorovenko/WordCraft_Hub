<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\PartOfSpeech;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        $partOfSpeech = PartOfSpeech::all();
        $selectedParts = [];

        return view('site.index', compact('words', 'partOfSpeech', 'selectedParts'));
    }

    public function filter(Request $request)
    {
        $partOfSpeech = PartOfSpeech::all();
        $selectedParts = $request->input('selectedParts', []);

        $query = Word::query();

        if (!empty($selectedParts)) {
            $query->whereHas('partsOfSpeech', function ($partQuery) use ($selectedParts) {
                $partQuery->whereIn('name', $selectedParts);
            });
        }

        $words = $query->with('partsOfSpeech')->orderBy('usage_count', 'desc')->get();

        return view('site.index', [
            'partOfSpeech' => $partOfSpeech,
            'words' => $words,
            'selectedParts' => $selectedParts,
        ]);
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
