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
        Schema::create('forum_post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('forum_post_id');
            $table->unsignedBigInteger('tag_id');
            $table->primary(['forum_post_id','tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_tags');
    }
};
