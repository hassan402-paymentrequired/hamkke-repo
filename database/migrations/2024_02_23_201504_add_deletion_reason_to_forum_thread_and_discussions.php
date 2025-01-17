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
        Schema::table('posts', function (Blueprint $table) {
            $table->text('deletion_reason')->nullable();
        });
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->text('deletion_reason')->nullable();
        });
        Schema::table('forum_discussions', function (Blueprint $table) {
            $table->text('deletion_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('deletion_reason');
        });
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn('deletion_reason');
        });
        Schema::table('forum_discussions', function (Blueprint $table) {
            $table->dropColumn('deletion_reason');
        });
    }
};
