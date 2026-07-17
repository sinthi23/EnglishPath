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

        $isEnrolled = $course->price > 0 
            ? $user->enrolledCourses()->where('course_id', $course->id)->exists() 
            : true;

        return view('student.courses.show', compact('course', 'lessons', 'isEnrolled'));
    }

    public function checkout(Request $request, Course $course)
    {
        abort_unless($course->is_published, 404);
        abort_unless($course->price > 0, 404);

        $user = $request->user();
        $isEnrolled = $user->enrolledCourses()->where('course_id', $course->id)->exists();
        if ($isEnrolled) {
            return redirect()->route('student.courses.show', $course);
        }

        return view('student.courses.checkout', compact('course'));
    }

    public function enroll(Request $request, Course $course)
    {
        abort_unless($course->is_published, 404);

        $user = $request->user();

        if ($course->price > 0) {
            $request->validate([
                'payment_method' => 'required|in:card,bkash',
                'transaction_id' => 'required|string|min:6',
            ], [
                'transaction_id.required' => 'Please provide the transaction ID (TxID) for verification.',
                'transaction_id.min' => 'Transaction ID must be at least 6 characters.',
            ]);
        }

        $user->enrolledCourses()->syncWithoutDetaching([$course->id]);

        return redirect()
            ->route('student.courses.show', $course)
            ->with('success', 'You have successfully enrolled in ' . $course->title . '!');
    }
}
