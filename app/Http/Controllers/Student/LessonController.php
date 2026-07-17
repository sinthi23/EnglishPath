<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::query()
            ->where('is_published', true)
            ->whereNull('course_id')
            ->orderBy('id')
            ->get();

        return view('student.lessons.index', compact('lessons'));
    }

    public function show(Request $request, Lesson $lesson)
    {
        abort_unless($lesson->is_published, 404);

        $request->session()->put('current_lesson', $lesson->id);

        $latestProgress = Progress::query()
            ->where('user_id', $request->user()->id)
            ->where('lesson_id', $lesson->id)
            ->latest('completed_at')
            ->first();

        if ($latestProgress?->score !== null) {
            $request->session()->put('quiz_score', $latestProgress->score);
        }

        return view('student.lessons.show', compact('lesson', 'latestProgress'));
    }
}
