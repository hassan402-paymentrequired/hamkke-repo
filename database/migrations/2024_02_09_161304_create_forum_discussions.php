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
        Schema::create('forum_discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_post_id');
            $table->unsignedBigInteger('parent_id')->nullable()
                ->comment('This is only set if this is not a direct reply to the main topic');
            $table->string('slug')->unique();
            $table->longText('body')->fulltext();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->tinyInteger('post_status_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('forum_post_id')->references('id')->on('forum_posts')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_discussions');
    }
};
