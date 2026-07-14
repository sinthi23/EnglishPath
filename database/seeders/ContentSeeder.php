<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\ReadingPassage;
use App\Models\Vocabulary;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'general-english-foundations'],
            [
                'title' => 'General English Foundations',
                'description' => 'Starter lessons for grammar, vocabulary, and reading practice.',
                'level' => 'beginner',
                'is_published' => true,
            ]
        );

        $lessonOne = Lesson::updateOrCreate(
            ['slug' => 'introducing-yourself-in-english'],
            [
                'course_id' => $course->id,
                'title' => 'Introducing Yourself in English',
                'level' => 'beginner',
                'difficulty' => 'beginner',
                'video_url' => 'https://example.com/videos/introducing-yourself',
                'content' => 'Learn simple greetings, names, and short self-introductions.',
                'is_published' => true,
            ]
        );

        Lesson::updateOrCreate(
            ['slug' => 'daily-routine-vocabulary'],
            [
                'course_id' => $course->id,
                'title' => 'Daily Routine Vocabulary',
                'level' => 'beginner',
                'difficulty' => 'beginner',
                'video_url' => 'https://example.com/videos/daily-routine',
                'content' => 'Practice words and phrases used for everyday routines.',
                'is_published' => true,
            ]
        );

        Vocabulary::updateOrCreate(
            ['word' => 'greeting'],
            [
                'meaning' => 'A word or gesture used to say hello.',
                'example' => 'Hello is a common greeting.',
                'synonym' => 'welcome',
                'antonym' => 'farewell',
                'difficulty' => 'beginner',
            ]
        );

        Vocabulary::updateOrCreate(
            ['word' => 'routine'],
            [
                'meaning' => 'A regular way of doing things every day.',
                'example' => 'My morning routine starts at 7 AM.',
                'synonym' => 'habit',
                'antonym' => 'surprise',
                'difficulty' => 'beginner',
            ]
        );

        ReadingPassage::updateOrCreate(
            ['slug' => 'my-first-day-at-school'],
            [
                'title' => 'My First Day at School',
                'difficulty' => 'beginner',
                'passage' => 'I went to school early. I met my teacher and new friends. We said hello and learned together.',
                'is_published' => true,
            ]
        );

        $quiz = Quiz::updateOrCreate(
            [
                'lesson_id' => $lessonOne->id,
                'reading_passage_id' => null,
                'title' => 'Introducing Yourself Quiz',
            ],
            [
                'difficulty' => 'beginner',
                'time_limit_minutes' => 10,
                'passing_score' => 50,
            ]
        );

        Question::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'question' => 'Which phrase is a greeting?',
            ],
            [
                'option_a' => 'Goodbye',
                'option_b' => 'Hello',
                'option_c' => 'Sleep',
                'option_d' => 'Study',
                'correct_answer' => 'B',
            ]
        );

        Question::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'question' => 'What do you say when meeting someone new?',
            ],
            [
                'option_a' => 'I am a student',
                'option_b' => 'Nice to meet you',
                'option_c' => 'See you later',
                'option_d' => 'I am hungry',
                'correct_answer' => 'B',
            ]
        );
    }
}
