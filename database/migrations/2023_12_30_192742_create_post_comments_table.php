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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('reply_to')->nullable()->index()
                ->comment('This is set to the comment that is being replied to if it is a reply');
            $table->text('body')->fulltext();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->index();
            $table->timestamp('deleted_at', 0)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
