<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index()
    {
        $vocabularies = Vocabulary::latest()->paginate(10);

        return view('admin.vocabularies.index', compact('vocabularies'));
    }

    public function create()
    {
        return view('admin.vocabularies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'word' => ['required', 'string', 'max:255'],
            'meaning' => ['required', 'string'],
            'example' => ['nullable', 'string'],
            'synonym' => ['nullable', 'string', 'max:255'],
            'antonym' => ['nullable', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        Vocabulary::create($validated);

        return redirect()->route('admin.vocabularies.index')->with('success', 'Vocabulary created successfully.');
    }

    public function edit(Vocabulary $vocabulary)
    {
        return view('admin.vocabularies.edit', compact('vocabulary'));
    }

    public function update(Request $request, Vocabulary $vocabulary)
    {
        $validated = $request->validate([
            'word' => ['required', 'string', 'max:255'],
            'meaning' => ['required', 'string'],
            'example' => ['nullable', 'string'],
            'synonym' => ['nullable', 'string', 'max:255'],
            'antonym' => ['nullable', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        $vocabulary->update($validated);

        return redirect()->route('admin.vocabularies.index')->with('success', 'Vocabulary updated successfully.');
    }

    public function destroy(Vocabulary $vocabulary)
    {
        $vocabulary->delete();

        return redirect()->route('admin.vocabularies.index')->with('success', 'Vocabulary deleted successfully.');
    }
}
