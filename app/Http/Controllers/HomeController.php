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
        $selectedFrequencyRange = [];
        $frequencyRange = ['Easy', 'Medium', 'Hard'];

        // Sort data
        $words = $words->sortByDesc('frequency');
        $partsOfSpeech = $partsOfSpeech->sortBy('name');

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts', 'frequencyRange', 'selectedFrequencyRange'));
    }

    public function filter(Request $request)
    {
        $partsOfSpeech = PartOfSpeech::all();
        $selectedParts = $request->input('parts', []);
        $selectedFrequencyRange = $request->input('frequency_range', []);
        $frequencyRange = ['Easy', 'Medium', 'Hard'];

        $query = Word::query();

        if (empty($selectedParts) && empty($selectedFrequencyRange)) {
            return redirect()->route('index');
        }

        $query->where(function ($query) use ($selectedFrequencyRange) {
            foreach ($selectedFrequencyRange as $range) {
                switch ($range) {
                    case 'Easy':
                        $query->orWhere('frequency', '>', 20);
                        break;
                    case 'Medium':
                        $query->orWhereBetween('frequency', [1, 20]);
                        break;
                    case 'Hard':
                        $query->orWhere('frequency', '<', 1);
                        break;
                }
            }
        });

        if (!empty($selectedParts)) {
            $query->whereHas('partOfSpeech', function ($partQuery) use ($selectedParts) {
                $partQuery->whereIn('name', $selectedParts);
            });
        }

        // Sort data
        $words = $query->orderByDesc('frequency')->get();
        $partsOfSpeech = $partsOfSpeech->sortBy('name');

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts', 'frequencyRange', 'selectedFrequencyRange'));
    }

    public function export()
    {
        $query = Word::query();

        $query->orderByDesc('frequency');
        $words = $query->get();

        $csvData = "Word,Translate,Frequency,Part of Speech\n";

        foreach ($words as $word) {
            // Используем метод pluck, чтобы получить массив имен тегов
            $partOfSpeech = $word->partOfSpeech->name;

            $csvData .= sprintf(
                "%s,%s,%s,%s\n",
                $word->word,
                $word->translate,
                $word->frequency,
                $partOfSpeech
            );
        }

        $filename = 'words' . date('Y-m-d_H-i-s') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
