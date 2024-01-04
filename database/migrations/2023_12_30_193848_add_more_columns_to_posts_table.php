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
            $table->unsignedBigInteger('post_author')->after('post_status_id');
            $table->text('featured_image')->nullable()->after('post_status_id');
            $table->foreign('post_author', 'post_author_foreign_index')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('post_author_foreign_index');
            $table->dropColumn('post_author');
            $table->dropColumn('featured_image');
        });
    }
};
