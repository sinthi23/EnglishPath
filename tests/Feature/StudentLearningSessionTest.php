<?php

use App\Models\Lesson;
use App\Models\Progress;
use App\Models\User;

test('opening a student lesson stores the current lesson in session', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $lesson = Lesson::create([
        'title' => 'Session Lesson',
        'slug' => 'session-lesson',
        'level' => 'beginner',
        'difficulty' => 'beginner',
        'video_url' => null,
        'content' => 'Lesson content for session testing.',
        'is_published' => true,
    ]);

    $response = $this->actingAs($user)->get(route('student.lessons.show', $lesson));

    $response->assertOk();
    $response->assertSessionHas('current_lesson', $lesson->id);
});

test('student dashboard stores quiz score goal and streak in session', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $lesson = Lesson::create([
        'title' => 'Dashboard Lesson',
        'slug' => 'dashboard-lesson',
        'level' => 'beginner',
        'difficulty' => 'beginner',
        'video_url' => null,
        'content' => 'Lesson content for dashboard testing.',
        'is_published' => true,
    ]);

    Progress::create([
        'user_id' => $user->id,
        'lesson_id' => $lesson->id,
        'completed' => true,
        'score' => 95,
        'completed_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('student.dashboard'));

    $response->assertOk();
    $response->assertSessionHas('quiz_score', 95);
    $response->assertSessionHas('daily_goal_target', 3);
    $response->assertSessionHas('daily_goal_completed', 1);
    $response->assertSessionHas('learning_streak', 1);
});
