<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\PartOfSpeech;

class HomeController extends Controller
{
    public function index()
    {
        $words = Word::all();
        $partsOfSpeech = PartOfSpeech::all();
        $selectedParts = [];

        // Sort data
        $words = $words->sortByDesc('frequency');
        $partsOfSpeech = $partsOfSpeech->sortBy('name');

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts'));
    }

    public function filter(Request $request)
    {
        $partsOfSpeech = PartOfSpeech::all();
        $selectedParts = $request->input('parts', []);

        if (empty($selectedParts)) {
            return redirect()->route('index');
        }

        $query = Word::query();

        if (!empty($selectedParts)) {
            $query->whereHas('partOfSpeech', function ($partQuery) use ($selectedParts) {
                $partQuery->whereIn('name', $selectedParts);
            });
        }

        // Sort data
        $words = $query->orderBy('frequency', 'desc')->get();
        $partsOfSpeech = $partsOfSpeech->sortBy('name');

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts'));
    }

    public function export()
    {
        $query = Word::query();

        $words = $query->with('partsOfSpeech')
            ->orderBy('frequency', 'desc')
            ->get();

        $csvData = "#,Word,Translate,Frequency,Parts of Speech\n";
        $count = 0;

        foreach ($words as $word) {
            // Используем метод pluck, чтобы получить массив имен тегов
            $partsOfSpeech = $word->partsOfSpeech->pluck('name')->implode(',');

            // Обертываем теги в двойные кавычки
            $partsOfSpeech = str_replace(',', ', ', $partsOfSpeech);
            $partsOfSpeech = '"' . str_replace('"', '""', $partsOfSpeech) . '"';

            $count++;

            $csvData .= sprintf(
                "%s,%s,%s,%s,%s\n",
                $count,
                $word->word,
                $word->translate,
                $word->frequency,
                $partsOfSpeech
            );
        }

        $filename = 'words' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
