<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\PartOfSpeech;

class HomeController extends Controller
{
    protected $words;
    protected $partsOfSpeech;
    protected $selectedParts;
    protected $frequencyRange;
    protected $selectedFrequencyRange;

    public function __construct()
    {
        $this->words = Word::all()->sortByDesc('frequency');
        $this->partsOfSpeech = PartOfSpeech::all()->sortBy('name');
        $this->selectedParts = [];
        $this->frequencyRange = ['easy', 'medium', 'hard'];
        $this->selectedFrequencyRange = [];
    }

    public function index()
    {
        $words = $this->words;
        $partsOfSpeech = $this->partsOfSpeech;
        $selectedParts = $this->selectedParts;
        $frequencyRange = $this->frequencyRange;
        $selectedFrequencyRange = $this->selectedFrequencyRange;

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

        if (empty($this->selectedParts) && empty($this->selectedFrequencyRange)) {
            return redirect()->route('index');
        }

        return view('site.index', compact('words', 'partsOfSpeech', 'selectedParts', 'frequencyRange', 'selectedFrequencyRange'));
    }

    public function export()
    {
        $words = $this->words;

        $csvData = "Word,Translate,Frequency,Part of Speech\n";

        foreach ($words as $word) {
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

    protected function applyFilter()
    {
        $query = Word::query()->orderByDesc('frequency');;

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

        return $query->get();
    }
}
