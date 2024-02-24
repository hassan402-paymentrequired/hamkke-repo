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
        Schema::create('forum_post_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('forum_post_id')->index();
            $table->unsignedBigInteger('model_id')->index();
            $table->unsignedBigInteger('model_table_name')->index();
            $table->timestamps();
            $table->primary(['forum_post_id','model_id', 'model_table_name'], 'forum_post_likes_PK');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_post_likes');
    }
};
