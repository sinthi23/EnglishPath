<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WritingTopic;
use Illuminate\Http\Request;

class WritingTopicController extends Controller
{
    public function index()
    {
        $topics = WritingTopic::latest()->paginate(10);
        return view('admin.writing.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.writing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'prompt' => ['required', 'string'],
            'min_words' => ['required', 'integer', 'min:1'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        WritingTopic::create($validated);

        return redirect()->route('admin.writing-topics.index')->with('success', 'Writing topic created successfully.');
    }

    public function edit(WritingTopic $writingTopic)
    {
        return view('admin.writing.edit', compact('writingTopic'));
    }

    public function update(Request $request, WritingTopic $writingTopic)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'prompt' => ['required', 'string'],
            'min_words' => ['required', 'integer', 'min:1'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        $writingTopic->update($validated);

        return redirect()->route('admin.writing-topics.index')->with('success', 'Writing topic updated successfully.');
    }

    public function destroy(WritingTopic $writingTopic)
    {
        $writingTopic->delete();
        return redirect()->route('admin.writing-topics.index')->with('success', 'Writing topic deleted successfully.');
    }
}
