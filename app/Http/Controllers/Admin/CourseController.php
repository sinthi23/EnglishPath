<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function show(Course $course)
    {
        $lessons = $course->lessons()->orderBy('id')->get();

        return view('admin.courses.show', compact('course', 'lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (Course::where('slug', $slug)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        Course::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'level' => $validated['level'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);

        while (Course::where('slug', $slug)->where('id', '!=', $course->id)->exists()) {
            $slug .= '-'.Str::random(4);
        }

        $course->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'level' => $validated['level'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
