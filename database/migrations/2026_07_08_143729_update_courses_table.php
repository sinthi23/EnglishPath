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
        if (! Schema::hasColumn('courses', 'title')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('title')->after('id');
            });
        }

        if (! Schema::hasColumn('courses', 'slug')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('slug')->unique()->after('title');
            });
        }

        if (! Schema::hasColumn('courses', 'description')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->text('description')->nullable()->after('slug');
            });
        }

        if (! Schema::hasColumn('courses', 'level')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->string('level')->default('beginner')->index()->after('description');
            });
        }

        if (! Schema::hasColumn('courses', 'is_published')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_published')->default(true)->index()->after('level');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'is_published')) {
                $table->dropIndex(['is_published']);
                $table->dropColumn('is_published');
            }

            if (Schema::hasColumn('courses', 'level')) {
                $table->dropIndex(['level']);
                $table->dropColumn('level');
            }

            if (Schema::hasColumn('courses', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('courses', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('courses', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};