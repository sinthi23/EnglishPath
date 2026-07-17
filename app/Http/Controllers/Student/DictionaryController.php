<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class DictionaryController extends Controller
{
    public function index()
    {
        return view('student.dictionary');
    }

    public function lookup(Request $request, $word)
    {
        if (!$word) {
            return response()->json(['error' => 'Please enter a word.'], 422);
        }

        $client = new Client();

        try {
            $base = env('DICTIONARY_API_BASE', 'https://api.dictionaryapi.dev/api/v2/entries/en');
            $response = $client->get("$base/$word");
            $data = json_decode($response->getBody(), true);
            $entry = $data[0];

            $meanings = [];
            $synonyms = [];
            foreach ($entry['meanings'] as $meaning) {
                $meanings[] = [
                    'partOfSpeech' => $meaning['partOfSpeech'],
                    'definition' => $meaning['definitions'][0]['definition'] ?? null,
                    'example' => $meaning['definitions'][0]['example'] ?? null,
                ];
                if (!empty($meaning['synonyms'])) {
                    $synonyms = array_merge($synonyms, $meaning['synonyms']);
                }
            }

            return response()->json([
                'word' => $entry['word'],
                'phonetic' => $entry['phonetic'] ?? null,
                'meanings' => $meanings,
                'synonyms' => array_slice(array_unique($synonyms), 0, 6),
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Word not found.'], 404);
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'word' => 'required|string',
            'meaning' => 'required|string',
            'example' => 'nullable|string',
            'synonym' => 'nullable|string',
        ]);

        $user = $request->user();

        $vocabulary = Vocabulary::where('word', $request->word)->first();
        if (!$vocabulary) {
            $vocabulary = Vocabulary::create([
                'word' => $request->word,
                'meaning' => $request->meaning,
                'example' => $request->example,
                'synonym' => $request->synonym,
                'difficulty' => 'medium',
            ]);
        }

        \App\Models\Bookmark::firstOrCreate([
            'user_id' => $user->id,
            'vocabulary_id' => $vocabulary->id,
        ]);

        return response()->json(['message' => 'Saved to your bookmarked vocabulary list!']);
    }
}
