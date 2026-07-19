<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

test('student users are redirected to the student dashboard', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('student.dashboard', absolute: false));
});

test('student dashboard shows learning metrics', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $now = now();

    DB::table('lessons')->insert([
        [
            'title' => 'Lesson One',
            'slug' => 'lesson-one',
            'level' => 'beginner',
            'difficulty' => 'beginner',
            'video_url' => null,
            'content' => 'Lesson content',
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'title' => 'Lesson Two',
            'slug' => 'lesson-two',
            'level' => 'beginner',
            'difficulty' => 'beginner',
            'video_url' => null,
            'content' => 'Lesson content',
            'is_published' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ]);

    DB::table('vocabularies')->insert([
        [
            'word' => 'apple',
            'meaning' => 'A fruit',
            'example' => null,
            'synonym' => null,
            'antonym' => null,
            'difficulty' => 'beginner',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'word' => 'book',
            'meaning' => 'A reading material',
            'example' => null,
            'synonym' => null,
            'antonym' => null,
            'difficulty' => 'beginner',
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ]);

    DB::table('bookmarks')->insert([
        'user_id' => $user->id,
        'lesson_id' => 1,
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    DB::table('progress')->insert([
        [
            'user_id' => $user->id,
            'lesson_id' => 1,
            'completed' => true,
            'score' => 88,
            'completed_at' => $now->copy()->subDay(),
            'created_at' => $now->copy()->subDay(),
            'updated_at' => $now->copy()->subDay(),
        ],
        [
            'user_id' => $user->id,
            'lesson_id' => 2,
            'completed' => true,
            'score' => 92,
            'completed_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ]);

    $response = $this->actingAs($user)->get(route('student.dashboard'));

    $response->assertOk();
    $response->assertSee('Lessons Finished');
    $response->assertSee('Vocabulary learned');
    $response->assertSee('Bookmarks');
    $response->assertSee('Recent Quiz');
    $response->assertSee('Overall Progress');
    $response->assertSee('2');
    $response->assertSee('92');
    $response->assertSee('Lesson Two');
});
