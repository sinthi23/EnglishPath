<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Lesson;
use App\Models\Progress;
use App\Models\Vocabulary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $publishedLessons = Lesson::query()
            ->where('is_published', true)
            ->orderBy('id')
            ->get();

        $completedLessons = Progress::query()
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        $bookmarkCount = Bookmark::query()
            ->where('user_id', $user->id)
            ->count();

        $vocabularyCount = Vocabulary::query()->count();

        $publishedLessonCount = $publishedLessons->count();

        $overallProgress = $publishedLessonCount > 0
            ? (int) round(($completedLessons / $publishedLessonCount) * 100)
            : 0;

        $recentQuiz = Progress::query()
            ->with('lesson')
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->first();

        $currentLessonId = $request->session()->get('current_lesson');
        $currentLesson = $currentLessonId
            ? Lesson::query()->where('is_published', true)->find($currentLessonId)
            : null;

        if (! $currentLesson) {
            $currentLesson = $recentQuiz?->lesson
                ?? $publishedLessons->first();
        }

        if ($currentLesson) {
            $request->session()->put('current_lesson', $currentLesson->id);
        }

        $quizScore = $recentQuiz?->score ?? $request->session()->get('quiz_score');
        if ($quizScore !== null) {
            $request->session()->put('quiz_score', $quizScore);
        }

        $dailyGoalTarget = 3;
        $dailyGoalCompleted = Progress::query()
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->whereDate('completed_at', today())
            ->count();

        $request->session()->put([
            'daily_goal_target' => $dailyGoalTarget,
            'daily_goal_completed' => $dailyGoalCompleted,
            'learning_streak' => $this->calculateLearningStreak($user->id),
        ]);

        return view('student.dashboard', compact(
            'bookmarkCount',
            'completedLessons',
            'currentLesson',
            'dailyGoalCompleted',
            'dailyGoalTarget',
            'overallProgress',
            'publishedLessonCount',
            'recentQuiz',
            'vocabularyCount',
        ));
    }

    private function calculateLearningStreak(int $userId): int
    {
        $dates = Progress::query()
            ->where('user_id', $userId)
            ->where('completed', true)
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->pluck('completed_at')
            ->map(fn ($date) => Carbon::parse($date)->startOfDay())
            ->unique(fn (Carbon $date) => $date->toDateString())
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $streak = 1;
        $previousDate = $dates->first();

        for ($index = 1; $index < $dates->count(); $index++) {
            $currentDate = $dates[$index];

            if ($previousDate->copy()->subDay()->toDateString() !== $currentDate->toDateString()) {
                break;
            }

            $streak++;
            $previousDate = $currentDate;
        }

        return $streak;
    }
}
