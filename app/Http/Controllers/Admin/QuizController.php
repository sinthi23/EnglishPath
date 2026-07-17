<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\ReadingPassage;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::latest()->paginate(10);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = Lesson::orderBy('title')->get();
        $readings = ReadingPassage::orderBy('title')->get();

        return view('admin.quizzes.create', compact('lessons', 'readings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'reading_passage_id' => ['nullable', 'exists:reading_passages,id'],
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::orderBy('title')->get();
        $readings = ReadingPassage::orderBy('title')->get();

        return view('admin.quizzes.edit', compact('quiz', 'lessons', 'readings'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'lesson_id' => ['nullable', 'exists:lessons,id'],
            'reading_passage_id' => ['nullable', 'exists:reading_passages,id'],
            'title' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:beginner,intermediate,advanced'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'in:A,B,C,D'],
        ]);

        $questionObj = $quiz->questions()->create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question added!',
                'question' => $questionObj,
            ]);
        }

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Question added!');
    }

    public function destroyQuestion(Quiz $quiz, \App\Models\Question $question)
    {
        $question->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Question deleted!',
            ]);
        }

        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Question deleted!');
    }
}
