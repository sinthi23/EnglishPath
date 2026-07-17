<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\WritingTopic;
use App\Models\WritingSubmission;
use Illuminate\Http\Request;

class WritingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $topics = WritingTopic::orderBy('id')->get();

        foreach ($topics as $topic) {
            // Find the best/latest submission by this user for this topic
            $submission = WritingSubmission::where('user_id', $user->id)
                ->where('writing_topic_id', $topic->id)
                ->latest()
                ->first();

            $topic->completed = !is_null($submission);
            $topic->score = $submission?->overall_score;
        }

        return view('student.writing.index', compact('topics'));
    }

    public function show(Request $request, WritingTopic $writingTopic)
    {
        $latestSubmission = WritingSubmission::where('user_id', $request->user()->id)
            ->where('writing_topic_id', $writingTopic->id)
            ->latest()
            ->first();

        return view('student.writing.show', compact('writingTopic', 'latestSubmission'));
    }

    public function submit(Request $request, WritingTopic $writingTopic)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:10'],
        ]);

        $content = $request->input('content');
        $user = $request->user();

        // 1. Calculate Word Count
        $words = preg_split('/\s+/', trim($content));
        $wordCount = count(array_filter($words));

        // 2. Length Score (Out of 100)
        $minWords = $writingTopic->min_words;
        if ($wordCount >= $minWords) {
            $lengthScore = 100;
        } else {
            $lengthScore = (int) round(($wordCount / $minWords) * 100);
        }

        // 3. Grammar & Structure Score (Out of 100)
        // Check for simple formatting errors
        $grammarErrors = 0;
        
        // Count sentences
        $sentences = preg_split('/[.!?]+/', trim($content));
        $sentences = array_filter(array_map('trim', $sentences));
        $sentenceCount = count($sentences);

        if ($sentenceCount < 3) {
            $grammarErrors += 20; // Short response, poor structure
        }

        // Check if sentences start with capital letters
        foreach ($sentences as $sentence) {
            if (!empty($sentence) && preg_match('/^[a-z]/', $sentence)) {
                $grammarErrors += 10; // Deduct for lowercase sentence starts
            }
        }

        // Check for double spaces or duplicate consecutive words
        if (preg_match('/\s{2,}/', $content)) {
            $grammarErrors += 5;
        }
        if (preg_match('/\b(\w+)\s+\1\b/i', $content)) {
            $grammarErrors += 10; // Duplicate words like "the the"
        }

        $grammarScore = max(30, 100 - $grammarErrors);

        // 4. Vocabulary Score (Out of 100)
        // Lexical diversity (unique words / total words)
        $uniqueWords = array_unique(array_map('strtolower', $words));
        $lexicalDiversity = $wordCount > 0 ? (count($uniqueWords) / $wordCount) : 0;
        
        // Long words (7+ letters) count
        $advancedWords = array_filter($words, function($w) {
            return strlen(preg_replace('/[^a-zA-Z]/', '', $w)) >= 7;
        });
        $advancedRatio = $wordCount > 0 ? (count($advancedWords) / $wordCount) : 0;

        // Map vocabulary score
        $vocabPoints = ($lexicalDiversity * 50) + ($advancedRatio * 150);
        $vocabScore = min(100, max(40, (int) round($vocabPoints)));

        // 5. Overall Score (Average of the three metrics)
        $overallScore = (int) round(($lengthScore + $grammarScore + $vocabScore) / 3);

        // 6. Generate feedback points
        $feedbackPoints = [];
        if ($wordCount < $minWords) {
            $feedbackPoints[] = "Your response is a bit short ({$wordCount} words). Try to elaborate more to reach the target of {$minWords} words.";
        } else {
            $feedbackPoints[] = "Good job on meeting the length requirements with {$wordCount} words!";
        }

        if ($grammarErrors > 0) {
            $feedbackPoints[] = "Make sure to capitalize the first letter of every sentence and check for double spaces or duplicate words.";
        } else {
            $feedbackPoints[] = "Great sentence punctuation and capitalization compliance.";
        }

        if ($vocabScore < 70) {
            $feedbackPoints[] = "Try to use more advanced vocabulary words (7+ letters) and avoid repeating the same terms.";
        } else {
            $feedbackPoints[] = "Excellent lexical variety! You used a rich selection of words in your writing.";
        }

        $feedback = implode("\n\n", $feedbackPoints);

        // Save submission
        $submission = WritingSubmission::create([
            'user_id' => $user->id,
            'writing_topic_id' => $writingTopic->id,
            'content' => $content,
            'grammar_score' => $grammarScore,
            'vocabulary_score' => $vocabScore,
            'length_score' => $lengthScore,
            'overall_score' => $overallScore,
            'feedback' => $feedback,
            'completed_at' => now(),
        ]);

        return redirect()->route('student.writing.result', $submission);
    }

    public function result(WritingSubmission $submission)
    {
        abort_unless($submission->user_id === auth()->id(), 403);
        $submission->load('topic');

        return view('student.writing.result', compact('submission'));
    }
}
