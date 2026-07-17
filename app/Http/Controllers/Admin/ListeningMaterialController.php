<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListeningMaterial;
use App\Models\ListeningQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListeningMaterialController extends Controller
{
    public function index()
    {
        $materials = ListeningMaterial::withCount('questions')->latest()->paginate(10);
        return view('admin.listening.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.listening.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'audio_file' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'], // 15MB max
            'audio_url' => ['nullable', 'url', 'required_without:audio_file'],
        ]);

        $audioUrl = $request->input('audio_url');

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            // Store directly in public folder for easy development sandbox access
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/audio'), $filename);
            $audioUrl = asset('uploads/audio/' . $filename);
        }

        ListeningMaterial::create([
            'title' => $request->title,
            'audio_url' => $audioUrl,
            'difficulty' => $request->difficulty,
        ]);

        return redirect()->route('admin.listening-materials.index')->with('success', 'Listening exercise created successfully.');
    }

    public function edit(ListeningMaterial $listeningMaterial)
    {
        $listeningMaterial->load('questions');
        return view('admin.listening.edit', compact('listeningMaterial'));
    }

    public function update(Request $request, ListeningMaterial $listeningMaterial)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'audio_file' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'],
            'audio_url' => ['nullable', 'url'],
        ]);

        $audioUrl = $request->input('audio_url') ?: $listeningMaterial->audio_url;

        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/audio'), $filename);
            $audioUrl = asset('uploads/audio/' . $filename);
        }

        $listeningMaterial->update([
            'title' => $request->title,
            'audio_url' => $audioUrl,
            'difficulty' => $request->difficulty,
        ]);

        return redirect()->route('admin.listening-materials.index')->with('success', 'Listening exercise updated successfully.');
    }

    public function destroy(ListeningMaterial $listeningMaterial)
    {
        $listeningMaterial->delete();
        return redirect()->route('admin.listening-materials.index')->with('success', 'Listening exercise deleted successfully.');
    }

    // Question management
    public function storeQuestion(Request $request, ListeningMaterial $listeningMaterial)
    {
        $validated = $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'in:A,B,C,D'],
        ]);

        $question = $listeningMaterial->questions()->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question added!',
                'question' => $question,
            ]);
        }

        return redirect()->route('admin.listening-materials.edit', $listeningMaterial)->with('success', 'Question added!');
    }

    public function destroyQuestion(Request $request, ListeningMaterial $listeningMaterial, ListeningQuestion $listeningQuestion)
    {
        $listeningQuestion->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question deleted!',
            ]);
        }

        return redirect()->route('admin.listening-materials.edit', $listeningMaterial)->with('success', 'Question deleted!');
    }
}
