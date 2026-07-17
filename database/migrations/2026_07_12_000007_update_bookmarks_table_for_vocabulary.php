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
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropForeign(['lesson_id']);
            });
        } catch (\Exception $e) {
            // Ignore if constraint doesn't exist
        }

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->index('user_id');
            });
        } catch (\Exception $e) {
            // Ignore if index already exists
        }

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'lesson_id']);
            });
        } catch (\Exception $e) {
            // Ignore if unique index doesn't exist
        }

        Schema::table('bookmarks', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id')->nullable()->change();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnDelete();
        });

        // Add vocabulary_id column if it doesn't exist
        if (!Schema::hasColumn('bookmarks', 'vocabulary_id')) {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->foreignId('vocabulary_id')->nullable()->after('lesson_id')->constrained('vocabularies')->cascadeOnDelete();
            });
        }

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->unique(['user_id', 'lesson_id', 'vocabulary_id']);
            });
        } catch (\Exception $e) {
            // Ignore if already unique
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'lesson_id', 'vocabulary_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropConstrainedForeignId('vocabulary_id');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropForeign(['lesson_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('bookmarks', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id')->nullable(false)->change();
            $table->foreign('lesson_id')->references('id')->on('lessons')->cascadeOnDelete();
        });

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->unique(['user_id', 'lesson_id']);
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->dropIndex(['user_id']);
            });
        } catch (\Exception $e) {}
    }
};
