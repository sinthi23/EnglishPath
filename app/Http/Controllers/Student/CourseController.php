<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Progress;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $courses = Course::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get();

        foreach ($courses as $course) {
            $lessonIds = $course->lessons()->where('is_published', true)->pluck('id');
            $totalLessons = $lessonIds->count();
            
            $completedLessons = Progress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('completed', true)
                ->count();

            $course->total_lessons = $totalLessons;
            $course->completed_lessons = $completedLessons;
            $course->progress_pct = $totalLessons > 0 
                ? (int) round(($completedLessons / $totalLessons) * 100) 
                : 0;
        }

        return view('student.courses.index', compact('courses'));
    }

    public function show(Request $request, Course $course)
    {
        abort_unless($course->is_published, 404);

        $lessons = $course->lessons()
            ->where('is_published', true)
            ->orderBy('id')
            ->get();

        $user = $request->user();
        foreach ($lessons as $lesson) {
            $progress = Progress::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();
            
            $lesson->completed = $progress?->completed ?? false;
            $lesson->score = $progress?->score;
        }

        return view('student.courses.show', compact('course', 'lessons'));
    }
}
