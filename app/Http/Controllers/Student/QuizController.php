<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Progress;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $quiz->load('questions');
        
        return view('student.quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $questions = $quiz->questions;
        $totalCount = $questions->count();
        
        if ($totalCount === 0) {
            return redirect()->back()->with('error', 'This quiz has no questions.');
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

        // Update progress in database
        if ($quiz->lesson_id) {
            Progress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $quiz->lesson_id,
                ],
                [
                    'completed' => true,
                    'score' => $score,
                    'completed_at' => now(),
                ]
            );
        } elseif ($quiz->reading_passage_id) {
            Progress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reading_passage_id' => $quiz->reading_passage_id,
                ],
                [
                    'completed' => true,
                    'score' => $score,
                    'completed_at' => now(),
                ]
            );
        }

        return view('student.quizzes.result', compact('quiz', 'score', 'correctCount', 'totalCount', 'gradedQuestions'));
    }
}
