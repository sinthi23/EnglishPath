<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCoursesTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_courses_catalog()
    {
        $user = User::factory()->create(['role' => 'student']);
        
        $course1 = Course::create([
            'title' => 'Beginner Course',
            'slug' => 'beginner-course',
            'description' => 'A starter course',
            'price' => 29,
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $course2 = Course::create([
            'title' => 'Intermediate Course',
            'slug' => 'intermediate-course',
            'description' => 'A middle course',
            'price' => 59,
            'level' => 'intermediate',
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get(route('student.courses.index'));

        $response->assertStatus(200);
        $response->assertSee('Beginner Course');
        $response->assertSee('Intermediate Course');
        $response->assertSee('৳29');
        $response->assertSee('৳59');
    }

    public function test_student_can_view_course_details()
    {
        $user = User::factory()->create(['role' => 'student']);

        $course = Course::create([
            'title' => 'Comprehensive English',
            'slug' => 'comprehensive-english',
            'description' => 'Description here',
            'price' => 49,
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'First Lesson of Course',
            'slug' => 'first-lesson-of-course',
            'level' => 'beginner',
            'difficulty' => 'beginner',
            'content' => 'Content here',
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get(route('student.courses.show', $course));

        $response->assertStatus(200);
        $response->assertSee('Comprehensive English');
        $response->assertSee('First Lesson of Course');
    }

    public function test_sequential_lesson_learning_redirects_to_course_details()
    {
        $user = User::factory()->create(['role' => 'student']);

        $course = Course::create([
            'title' => 'Math Course',
            'slug' => 'math-course',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $lesson1 = Lesson::create([
            'id' => 10,
            'course_id' => $course->id,
            'title' => 'Lesson Ten',
            'slug' => 'lesson-ten',
            'level' => 'beginner',
            'difficulty' => 'beginner',
            'content' => 'Content ten',
            'is_published' => true,
        ]);

        $lesson2 = Lesson::create([
            'id' => 11,
            'course_id' => $course->id,
            'title' => 'Lesson Eleven',
            'slug' => 'lesson-eleven',
            'level' => 'beginner',
            'difficulty' => 'beginner',
            'content' => 'Content eleven',
            'is_published' => true,
        ]);

        // Student tries to view lesson 11 without completing lesson 10
        $response = $this->actingAs($user)->get(route('student.lessons.show', $lesson2));

        // It should redirect to the course details page
        $response->assertRedirect(route('student.courses.show', $course));
        $response->assertSessionHas('error');
    }

    public function test_dictionary_word_lookup_works_and_save_is_enabled()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get(route('student.dictionary.index'));
        $response->assertStatus(200);

        $saveResponse = $this->actingAs($user)->post(route('student.dictionary.save'), [
            'word' => 'resilience',
            'meaning' => 'The capacity to recover quickly from difficulties.',
            'example' => 'Showing great resilience.',
            'synonym' => 'toughness',
        ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['message' => 'Saved to your bookmarked vocabulary list!']);

        $this->assertDatabaseHas('vocabularies', [
            'word' => 'resilience',
        ]);
    }

    public function test_admin_can_view_course_details_with_syllabus()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $course = Course::create([
            'title' => 'Admin Test Course',
            'slug' => 'admin-test-course',
            'description' => 'Syllabus breakdown',
            'price' => 199,
            'level' => 'advanced',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Advanced Lesson One',
            'slug' => 'advanced-lesson-one',
            'level' => 'advanced',
            'difficulty' => 'advanced',
            'content' => 'Advanced stuff',
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.courses.show', $course));

        $response->assertStatus(200);
        $response->assertSee('Admin Test Course');
        $response->assertSee('৳199 BDT');
        $response->assertSee('Advanced Lesson One');
    }

    public function test_admin_can_save_course_price()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'title' => 'Premium Course Title',
            'description' => 'A valuable course',
            'price' => 250,
            'level' => 'intermediate',
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Premium Course Title',
            'price' => 250,
        ]);
    }

    public function test_student_cannot_access_paid_course_lesson_without_enrollment()
    {
        $user = User::factory()->create(['role' => 'student']);

        $course = Course::create([
            'title' => 'Paid Course Title',
            'slug' => 'paid-course-title',
            'description' => 'A paid course description',
            'price' => 100,
            'level' => 'intermediate',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Syllabus Lesson One',
            'slug' => 'syllabus-lesson-one',
            'level' => 'intermediate',
            'difficulty' => 'intermediate',
            'content' => 'First lesson content',
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get(route('student.lessons.show', $lesson));

        $response->assertRedirect(route('student.courses.show', $course));
        $response->assertSessionHas('error');
    }

    public function test_student_can_enroll_in_paid_course()
    {
        $user = User::factory()->create(['role' => 'student']);

        $course = Course::create([
            'title' => 'Premium Course Title 2',
            'slug' => 'premium-course-title-2',
            'description' => 'A premium course description',
            'price' => 120,
            'level' => 'advanced',
            'is_published' => true,
        ]);

        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Premium Lesson One',
            'slug' => 'premium-lesson-one',
            'level' => 'advanced',
            'difficulty' => 'advanced',
            'content' => 'First advanced lesson content',
            'is_published' => true,
        ]);

        // 1. Verify checkout page displays course details and price
        $checkoutResponse = $this->actingAs($user)->get(route('student.courses.checkout', $course));
        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertSee('Premium Course Title 2');
        $checkoutResponse->assertSee('৳120 BDT');

        // 2. Try enrolling without payment information (should fail validation)
        $invalidResponse = $this->actingAs($user)->post(route('student.courses.enroll', $course));
        $invalidResponse->assertSessionHasErrors(['payment_method', 'transaction_id']);

        // 3. Enroll with correct details
        $response = $this->actingAs($user)->post(route('student.courses.enroll', $course), [
            'payment_method' => 'bkash',
            'transaction_id' => 'TXN12345678',
        ]);

        $response->assertRedirect(route('student.courses.show', $course));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $lessonResponse = $this->actingAs($user)->get(route('student.lessons.show', $lesson));
        $lessonResponse->assertStatus(200);
        $lessonResponse->assertSee('Premium Lesson One');
    }
}
