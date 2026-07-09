<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->latest()->paginate(10);

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['nullable', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'video_url' => ['nullable', 'url'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (Lesson::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        Lesson::create([
            'course_id' => $validated['course_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'level' => $validated['level'],
            'difficulty' => $validated['difficulty'],
            'video_url' => $validated['video_url'] ?? null,
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'course_id' => ['nullable', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'video_url' => ['nullable', 'url'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (Lesson::where('slug', $slug)->where('id', '!=', $lesson->id)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        $lesson->update([
            'course_id' => $validated['course_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'level' => $validated['level'],
            'difficulty' => $validated['difficulty'],
            'video_url' => $validated['video_url'] ?? null,
            'content' => $validated['content'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
