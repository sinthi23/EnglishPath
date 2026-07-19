<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WritingTopic;
use App\Models\WritingSubmission;
use App\Models\ListeningMaterial;
use App\Models\ListeningQuestion;
use App\Models\ListeningAttempt;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Progress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingAndListeningTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->student = User::factory()->create([
            'role' => 'student',
        ]);
    }

    /** @test */
    public function admin_can_manage_writing_topics()
    {
        $this->actingAs($this->admin);

        // 1. Create a writing topic
        $response = $this->post(route('admin.writing-topics.store'), [
            'title' => 'My Future Career',
            'prompt' => 'Write about your career aspirations and where you see yourself in 10 years.',
            'min_words' => 50,
            'difficulty' => 'beginner',
        ]);

        $response->assertRedirect(route('admin.writing-topics.index'));
        $this->assertDatabaseHas('writing_topics', [
            'title' => 'My Future Career',
        ]);

        $topic = WritingTopic::first();

        // 2. Edit the writing topic
        $response = $this->put(route('admin.writing-topics.update', $topic), [
            'title' => 'My Future Career (Updated)',
            'prompt' => 'Write about your career aspirations and where you see yourself in 10 years.',
            'min_words' => 70,
            'difficulty' => 'intermediate',
        ]);

        $response->assertRedirect(route('admin.writing-topics.index'));
        $this->assertDatabaseHas('writing_topics', [
            'title' => 'My Future Career (Updated)',
            'min_words' => 70,
            'difficulty' => 'intermediate',
        ]);

        // 3. Delete the writing topic
        $response = $this->delete(route('admin.writing-topics.destroy', $topic));
        $response->assertRedirect(route('admin.writing-topics.index'));
        $this->assertDatabaseMissing('writing_topics', [
            'id' => $topic->id,
        ]);
    }

    /** @test */
    public function student_can_view_and_submit_writing_topics()
    {
        $topic = WritingTopic::create([
            'title' => 'My Dream Job',
            'prompt' => 'Describe your dream job and what skills you need to achieve it.',
            'min_words' => 30,
            'difficulty' => 'beginner',
        ]);

        $this->actingAs($this->student);

        // 1. View catalog
        $response = $this->get(route('student.writing.index'));
        $response->assertStatus(200);
        $response->assertSee('My Dream Job');

        // 2. Show topic
        $response = $this->get(route('student.writing.show', $topic));
        $response->assertStatus(200);

        // 3. Submit essay
        $response = $this->post(route('student.writing.submit', $topic), [
            'content' => 'My dream job is to be a software architect. I love building smart systems and writing clean code daily.',
        ]);

        $submission = WritingSubmission::first();
        $this->assertNotNull($submission);
        $this->assertEquals($this->student->id, $submission->user_id);
        
        // Assert redirected to result
        $response->assertRedirect(route('student.writing.result', $submission));
    }

    /** @test */
    public function admin_can_manage_listening_exercises_and_questions_via_ajax()
    {
        $this->actingAs($this->admin);

        // 1. Create a listening exercise
        $response = $this->post(route('admin.listening-materials.store'), [
            'title' => 'Airport Announcement Practice',
            'difficulty' => 'beginner',
            'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        ]);

        $response->assertRedirect(route('admin.listening-materials.index'));
        $this->assertDatabaseHas('listening_materials', [
            'title' => 'Airport Announcement Practice',
        ]);

        $exercise = ListeningMaterial::first();

        // 2. Add question via AJAX
        $response = $this->postJson(route('admin.listening-materials.questions.store', $exercise), [
            'question' => 'Where is flight 202 boarding?',
            'option_a' => 'Gate 10',
            'option_b' => 'Gate 12',
            'option_c' => 'Gate 15',
            'option_d' => 'Gate 20',
            'correct_answer' => 'C',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('listening_questions', [
            'listening_material_id' => $exercise->id,
            'question' => 'Where is flight 202 boarding?',
        ]);

        $question = ListeningQuestion::first();

        // 3. Delete question via AJAX
        $response = $this->deleteJson(route('admin.listening-materials.questions.destroy', [$exercise, $question]));
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseMissing('listening_questions', [
            'id' => $question->id,
        ]);
    }

    /** @test */
    public function student_can_practice_listening_exercises()
    {
        $exercise = ListeningMaterial::create([
            'title' => 'Business Meeting',
            'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
            'difficulty' => 'intermediate',
        ]);

        $question = $exercise->questions()->create([
            'question' => 'What is the budget projection for next quarter?',
            'option_a' => '10k',
            'option_b' => '50k',
            'option_c' => '100k',
            'option_d' => '200k',
            'correct_answer' => 'C',
        ]);

        $this->actingAs($this->student);

        // 1. View listening catalog
        $response = $this->get(route('student.listening.index'));
        $response->assertStatus(200);
        $response->assertSee('Business Meeting');

        // 2. Submit answers
        $response = $this->post(route('student.listening.submit', $exercise), [
            'answers' => [
                $question->id => 'C'
            ]
        ]);

        $response->assertStatus(200); // Renders result directly
        $response->assertSee('100%');
        
        $attempt = ListeningAttempt::first();
        $this->assertNotNull($attempt);
        $this->assertEquals(100, $attempt->score);
    }
}
