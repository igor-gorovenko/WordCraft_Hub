<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Word;
use App\Models\PartOfSpeech;
use App\Http\Requests\StoreWordRequest;
use Illuminate\Support\Str;

class WordController extends Controller
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function show($slug)
    {
        $word = Word::where('slug', $slug)->first();

        return view('site.show', compact('word'));
    }

    public function create()
    {
        return view('site.create');
    }

    public function store(StoreWordRequest $request)
    {
        $wordList = $request->input('wordList');

        $wordsArray = $this->splitWords(strtolower($wordList));

        foreach ($wordsArray as $wordValue) {
            if ($wordValue !== '') {
                $existingWord = Word::where('word', $wordValue)->first();

                if (!$existingWord) {
                    $this->createWord($wordValue);
                }
            }
        }

        return redirect()->route('index')->with('success', 'Words processed successfully');
    }

    protected function splitWords($wordList)
    {
        $delimiters = [" ", "%0D%0A", "\n", "\r"];
        $replaceDelimiter = '|';

        $wordList = str_replace($delimiters, $replaceDelimiter, $wordList);

        return explode($replaceDelimiter, $wordList);
    }

    protected function createWord($word)
    {
        $perMillion = $this->getWordFrequency($word);

        $partsOfSpeech = $this->getWordPartOfSpeech($word);

        $newWordsList = [];

        foreach ($partsOfSpeech as $part) {

            $translation = $this->getTranslation($word);

            $newWord = Word::create([
                'word' => $word,
                'translate' => $translation,
                'frequency' => $perMillion,
                'slug' => Str::slug($word, '-') . '-' . Str::slug($part, '-'),
            ]);

            // Получите id части речи из базы данных, используя ее название
            $partId = PartOfSpeech::where('name', $part)->value('id');

            // Присваиваем часть речи слову
            $newWord->partsOfSpeech()->attach($partId);

            $newWordsList[] = $newWord;
        }

        return $newWordsList;
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
                'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
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
                'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
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
                'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
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
