<?php

use App\Models\PostCategory;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->unsignedInteger('post_category_id');
            $table->text('summary');
            $table->longText('body')->fulltext();
            $table->tinyInteger('post_status_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_category_id')->references('id')->on('post_categories')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
