<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingPassage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReadingPassageController extends Controller
{
    public function index()
    {
        $readingPassages = ReadingPassage::latest()->paginate(10);

        return view('admin.readings.index', compact('readingPassages'));
    }

    public function create()
    {
        return view('admin.readings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'passage' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (ReadingPassage::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        ReadingPassage::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'difficulty' => $validated['difficulty'],
            'passage' => $validated['passage'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.readings.index')->with('success', 'Reading passage created successfully.');
    }

    public function edit(ReadingPassage $reading)
    {
        return view('admin.readings.edit', ['readingPassage' => $reading]);
    }

    public function update(Request $request, ReadingPassage $reading)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'passage' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (ReadingPassage::where('slug', $slug)->where('id', '!=', $reading->id)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        $reading->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'difficulty' => $validated['difficulty'],
            'passage' => $validated['passage'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.readings.index')->with('success', 'Reading passage updated successfully.');
    }

    public function destroy(ReadingPassage $reading)
    {
        $reading->delete();

        return redirect()->route('admin.readings.index')->with('success', 'Reading passage deleted successfully.');
    }
}
