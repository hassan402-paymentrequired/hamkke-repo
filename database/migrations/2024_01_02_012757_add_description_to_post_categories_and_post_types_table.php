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
        Schema::table('post_types', function (Blueprint $table) {
            $table->text('description')->after('slug')->nullable();
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->text('description')->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_types', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};