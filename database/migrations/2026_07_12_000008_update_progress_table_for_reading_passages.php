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
        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropForeign(['lesson_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->index('user_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'lesson_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('progress', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id')->nullable()->change();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnDelete();
        });

        if (!Schema::hasColumn('progress', 'reading_passage_id')) {
            Schema::table('progress', function (Blueprint $table) {
                $table->foreignId('reading_passage_id')->nullable()->after('lesson_id')->constrained('reading_passages')->cascadeOnDelete();
            });
        }

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->unique(['user_id', 'lesson_id', 'reading_passage_id']);
            });
        } catch (\Exception $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'lesson_id', 'reading_passage_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropConstrainedForeignId('reading_passage_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropForeign(['lesson_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('progress', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id')->nullable(false)->change();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnDelete();
        });

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->unique(['user_id', 'lesson_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('progress', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
            });
        } catch (\Exception $e) {}
    }
};
