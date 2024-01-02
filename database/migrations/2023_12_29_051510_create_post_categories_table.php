<?php

use App\Models\PostType;
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
        Schema::create('post_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_type_id');
            $table->string('name')->unique();
            $table->string('slug')->index();
            $table->string('navigation_icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_type_id', 'pc_post_type_index')
                ->references('id')->on('post_types')
                ->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
