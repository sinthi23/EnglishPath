<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ReadingPassage;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function index()
    {
        $passages = ReadingPassage::where('is_published', true)
            ->orderBy('id')
            ->paginate(9);

        return view('student.readings.index', compact('passages'));
    }

    public function show(ReadingPassage $reading)
    {
        abort_unless($reading->is_published, 404);

        // Load the quiz associated with this reading passage
        $quiz = $reading->quiz()->with('questions')->first();

        $latestProgress = \App\Models\Progress::where('user_id', auth()->id())
            ->where('reading_passage_id', $reading->id)
            ->latest('completed_at')
            ->first();

        return view('student.readings.show', compact('reading', 'quiz', 'latestProgress'));
    }
}
