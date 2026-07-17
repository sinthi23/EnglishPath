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
        Schema::create('writing_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('prompt');
            $table->unsignedInteger('min_words')->default(50);
            $table->string('difficulty')->default('beginner')->index();
            $table->timestamps();
        });

        Schema::create('writing_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('writing_topic_id')->constrained('writing_topics')->cascadeOnDelete();
            $table->text('content');
            $table->unsignedTinyInteger('grammar_score')->default(0);
            $table->unsignedTinyInteger('vocabulary_score')->default(0);
            $table->unsignedTinyInteger('length_score')->default(0);
            $table->unsignedTinyInteger('overall_score')->default(0);
            $table->text('feedback')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writing_submissions');
        Schema::dropIfExists('writing_topics');
    }
};
