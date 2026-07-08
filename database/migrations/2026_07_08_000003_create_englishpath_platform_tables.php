<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('level')->index();
            $table->string('difficulty')->default('beginner')->index();
            $table->string('video_url')->nullable();
            $table->longText('content');
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->string('word')->index();
            $table->text('meaning');
            $table->text('example')->nullable();
            $table->string('synonym')->nullable();
            $table->string('antonym')->nullable();
            $table->string('difficulty')->default('beginner')->index();
            $table->timestamps();
        });

        Schema::create('reading_passages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('difficulty')->default('beginner')->index();
            $table->longText('passage');
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->nullOnDelete();
            $table->foreignId('reading_passage_id')->nullable()->constrained('reading_passages')->nullOnDelete();
            $table->string('title');
            $table->string('difficulty')->default('beginner')->index();
            $table->unsignedSmallInteger('time_limit_minutes')->nullable();
            $table->unsignedSmallInteger('passing_score')->default(50);
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);
            $table->timestamps();
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });

        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->boolean('completed')->default(false)->index();
            $table->unsignedSmallInteger('score')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('reading_passages');
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('lessons');
    }
};
