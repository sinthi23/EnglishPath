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
        Schema::create('listening_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('audio_url');
            $table->string('difficulty')->default('beginner')->index();
            $table->timestamps();
        });

        Schema::create('listening_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listening_material_id')->constrained('listening_materials')->cascadeOnDelete();
            $table->text('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);
            $table->timestamps();
        });

        Schema::create('listening_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('listening_material_id')->constrained('listening_materials')->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listening_attempts');
        Schema::dropIfExists('listening_questions');
        Schema::dropIfExists('listening_materials');
    }
};
