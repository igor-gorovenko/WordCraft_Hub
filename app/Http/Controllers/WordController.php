<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\PartOfSpeech;

class WordController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function create()
    {
        return view('site.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        $word = $request->input('word');
        $translation = $this->getTranslation($word);
        $perMillion = $this->getWordFrequency($word);
        $partOfSpeech = $this->getWordPartOfSpeech($word);

        $word = new Word([
            'word' => $word,
            'translate' => $translation,
            'frequency' => $perMillion,
        ]);

        $word->save();

        // Получите id частей речи из базы данных, используя их названия
        $partOfSpeechIds = PartOfSpeech::whereIn('name', $partOfSpeech)->pluck('id')->toArray();

        // Присваиваем части речи слову
        $word->partsOfSpeech()->attach($partOfSpeechIds);

        if ($word->save()) {
            return redirect()->route('index')->with('success', 'Create new word');
        } else {
            return redirect()->back()->with('error', 'Failed to create new word');
        }
    }

    protected function getTranslation($word)
    {
        $response = $this->client->request('POST', 'https://google-translate113.p.rapidapi.com/api/v1/translator/text', [
            'form_params' => [
                'from' => 'en',
                'to' => 'ru',
                'text' => $word,
            ],
            'headers' => [
                'X-RapidAPI-Host' => 'google-translate113.p.rapidapi.com',
                'X-RapidAPI-Key' => 'eb50749f2cmshdecefc5a0e13308p1df499jsn71ec09d865a6',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $translationData = json_decode($response->getBody()->getContents(), true);

        return isset($translationData['trans']) ? $translationData['trans'] : 'Translation not available';
    }

    protected function getWordFrequency($word)
    {
        $response = $this->client->request('GET', "https://wordsapiv1.p.rapidapi.com/words/{$word}/frequency", [
            'headers' => [
                'X-RapidAPI-Host' => 'wordsapiv1.p.rapidapi.com',
                'X-RapidAPI-Key' => 'eb50749f2cmshdecefc5a0e13308p1df499jsn71ec09d865a6',
            ],
        ]);

        $wordsApiData = json_decode($response->getBody()->getContents(), true);

        return isset($wordsApiData['frequency']['perMillion']) ? $wordsApiData['frequency']['perMillion'] : 0;
    }

    protected function getWordPartOfSpeech($word)
    {
        $response = $this->client->request('GET', "https://wordsapiv1.p.rapidapi.com/words/{$word}/definitions", [
            'headers' => [
                'X-RapidAPI-Host' => 'wordsapiv1.p.rapidapi.com',
                'X-RapidAPI-Key' => 'eb50749f2cmshdecefc5a0e13308p1df499jsn71ec09d865a6',
            ],
        ]);

        $wordsApiData = json_decode($response->getBody()->getContents(), true);

        // Получаем определения из ответа API
        $definitions = $wordsApiData['definitions'];

        // Инициализируем массив для хранения уникальных частей речи
        $uniquePartsOfSpeech = [];

        // Итерируем по определениям и добавляем уникальные части речи в массив
        foreach ($definitions as $definition) {
            $partOfSpeech = $definition['partOfSpeech'];

            // Проверяем, что часть речи еще не была добавлена
            if (!in_array($partOfSpeech, $uniquePartsOfSpeech)) {
                $uniquePartsOfSpeech[] = $partOfSpeech;
            }
        }

        // Возвращаем уникальные части речи
        return $uniquePartsOfSpeech;
    }
}
