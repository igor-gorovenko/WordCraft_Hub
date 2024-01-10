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

    public function destroy($slug)
    {
        $word = Word::where('slug', $slug)->firstOrFail();
        $word->delete();

        return redirect()->route('index')->with('success', 'word deleted');
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

            $translation = $this->getTranslation($word, $part);

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

    protected function getTranslation($word, $part)
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

        $data = json_decode($response->getBody()->getContents(), true);

        // Обходим массив "dict"
        foreach ($data['dict'] as $dictItem) {
            // Проверяем соответствие типа речи
            if (isset($dictItem['pos']) && $dictItem['pos'] === $part) {
                // Извлекаем перевод из первого элемента "entry"
                $translation = $dictItem['entry'][0]['word'];

                return $translation;
            }
        }

        return 'Translation not available';
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

        // Получаем данные из API
        $data = json_decode($response->getBody()->getContents(), true);

        $partsOfSpeech = [];

        $partsOfSpeech = collect($data['dict'])
            ->pluck('pos') // Извлекаем типы речи
            ->reject(function ($pos) { // удаляем пустые строки
                return empty($pos);
            })
            ->unique() // Оставляем уникальные значения
            ->values() // Сбрасываем ключи массива
            ->toArray();

        foreach ($partsOfSpeech as $part) {
            $this->addPartOfSpeechIfNotExists($part);
        }

        return $partsOfSpeech;
    }

    protected function addPartOfSpeechIfNotExists($part)
    {
        // Пытаемся найти запись с заданным типом речи
        $existingPart = PartOfSpeech::where('name', $part)->first();

        // Если запись не найдена, создаем новую
        if (!$existingPart) {
            PartOfSpeech::create([
                'name' => $part,
                'slug' => Str::slug($part, '-'),
            ]);
        }
    }
}
