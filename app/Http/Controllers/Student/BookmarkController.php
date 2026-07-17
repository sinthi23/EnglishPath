<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Lesson;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookmarkedLessons = Lesson::query()
            ->join('bookmarks', 'lessons.id', '=', 'bookmarks.lesson_id')
            ->where('bookmarks.user_id', $user->id)
            ->select('lessons.*')
            ->get();

        $bookmarkedVocabs = Vocabulary::query()
            ->join('bookmarks', 'vocabularies.id', '=', 'bookmarks.vocabulary_id')
            ->where('bookmarks.user_id', $user->id)
            ->select('vocabularies.*')
            ->get();

        return view('student.bookmarks', compact('bookmarkedLessons', 'bookmarkedVocabs'));
    }

    public function toggleLesson(Request $request, Lesson $lesson)
    {
        $user = $request->user();
        
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $status = 'removed';
            $message = 'Lesson removed from bookmarks.';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ]);
            $status = 'added';
            $message = 'Lesson saved to bookmarks.';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleVocabulary(Request $request, Vocabulary $vocabulary)
    {
        $user = $request->user();
        
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('vocabulary_id', $vocabulary->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $status = 'removed';
            $message = 'Word removed from bookmarks.';
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'vocabulary_id' => $vocabulary->id,
            ]);
            $status = 'added';
            $message = 'Word saved to bookmarks.';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
