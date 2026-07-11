<?php

namespace App\Http\Middleware;

use App\Models\Lesson;
use App\Models\Progress;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompletedLessonMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lesson = $request->route('lesson');

        if (! $lesson instanceof Lesson) {
            return $next($request);
        }

        $previousLesson = Lesson::query()
            ->where('course_id', $lesson->course_id)
            ->where('is_published', true)
            ->where('id', '<', $lesson->id)
            ->orderByDesc('id')
            ->first();

        if (! $previousLesson) {
            return $next($request);
        }

        $hasCompletedPreviousLesson = Progress::query()
            ->where('user_id', $request->user()->id)
            ->where('lesson_id', $previousLesson->id)
            ->where('completed', true)
            ->exists();

        if (! $hasCompletedPreviousLesson) {
            return redirect()
                ->route('student.lessons.index')
                ->with('error', 'Complete ' . $previousLesson->title . ' before opening ' . $lesson->title . '.');
        }

        return $next($request);
    }
}
