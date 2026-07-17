<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ListeningMaterial;
use App\Models\ListeningAttempt;
use App\Models\ListeningQuestion;
use Illuminate\Http\Request;

class ListeningController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $materials = ListeningMaterial::withCount('questions')->orderBy('id')->get();

        foreach ($materials as $material) {
            $attempt = ListeningAttempt::where('user_id', $user->id)
                ->where('listening_material_id', $material->id)
                ->latest()
                ->first();

            $material->completed = !is_null($attempt);
            $material->score = $attempt?->score;
        }

        return view('student.listening.index', compact('materials'));
    }

    public function show(ListeningMaterial $listeningMaterial)
    {
        $listeningMaterial->load('questions');
        return view('student.listening.show', compact('listeningMaterial'));
    }

    public function submit(Request $request, ListeningMaterial $listeningMaterial)
    {
        $questions = $listeningMaterial->questions;
        $totalCount = $questions->count();

        if ($totalCount === 0) {
            return redirect()->back()->with('error', 'This exercise has no questions.');
        }

        $answers = $request->input('answers', []);
        $correctCount = 0;
        $gradedQuestions = [];

        foreach ($questions as $question) {
            $submittedAnswer = $answers[$question->id] ?? null;
            $isCorrect = (strtoupper($submittedAnswer) === strtoupper($question->correct_answer));

            if ($isCorrect) {
                $correctCount++;
            }

            $gradedQuestions[] = [
                'question' => $question,
                'submitted' => $submittedAnswer,
                'correct' => $question->correct_answer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = (int) round(($correctCount / $totalCount) * 100);
        $user = $request->user();

        // Save progress to database
        $attempt = ListeningAttempt::create([
            'user_id' => $user->id,
            'listening_material_id' => $listeningMaterial->id,
            'score' => $score,
            'completed_at' => now(),
        ]);

        // Redirect to a result page, sharing the evaluation context
        return view('student.listening.result', compact('listeningMaterial', 'attempt', 'score', 'correctCount', 'totalCount', 'gradedQuestions'));
    }
}
