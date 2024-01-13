<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\PartOfSpeech;

class HomeController extends Controller
{

    protected $partsOfSpeech;
    protected $selectedParts;
    protected $frequencyRange;
    protected $selectedFrequencyRange;

    public function __construct()
    {
        $this->partsOfSpeech = PartOfSpeech::all();
        $this->selectedParts = [];
        $this->frequencyRange = ['easy', 'medium', 'hard'];
        $this->selectedFrequencyRange = [];
    }

    public function index()
    {
        $words = $this->applyFilter();
        $partsOfSpeech = $this->partsOfSpeech;
        $selectedParts = $this->selectedParts;
        $frequencyRange = $this->frequencyRange;
        $selectedFrequencyRange = $this->selectedFrequencyRange;

        // Sort data
        $words = $words->sortByDesc('frequency');
        $partsOfSpeech = $partsOfSpeech->sortBy('name');

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts', 'frequencyRange', 'selectedFrequencyRange'));
    }

    public function filter(Request $request)
    {
        $this->selectedParts = $request->input('parts', []);
        $this->selectedFrequencyRange = $request->input('range', []);

        $words = $this->applyFilter();
        $partsOfSpeech = $this->partsOfSpeech;
        $selectedParts = $this->selectedParts;
        $frequencyRange = $this->frequencyRange;
        $selectedFrequencyRange = $this->selectedFrequencyRange;

        // Если нужен редирект, добавьте условие
        if (empty($this->selectedParts) && empty($this->selectedFrequencyRange)) {
            return redirect()->route('index');
        }

        // Sort data
        $words = $words->sortByDesc('frequency');
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

    protected function applyFilter(Request $request = null)
    {
        $query = Word::query();

        $query->where(function ($query) {
            foreach ($this->selectedFrequencyRange as $range) {
                switch ($range) {
                    case 'easy':
                        $query->orWhere('frequency', '>', 20);
                        break;
                    case 'medium':
                        $query->orWhereBetween('frequency', [1, 20]);
                        break;
                    case 'hard':
                        $query->orWhere('frequency', '<', 1);
                        break;
                }
            }
        });

        if (!empty($this->selectedParts)) {
            $query->whereHas('partOfSpeech', function ($partQuery) {
                $partQuery->whereIn('name', $this->selectedParts);
            });
        }

        return $query->orderByDesc('frequency')->get();
    }
}
