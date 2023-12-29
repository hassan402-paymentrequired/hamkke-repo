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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('string_value')->nullable();
            $table->json('json_value')->nullable();
            $table->boolean('core_site_setting')->default(false)->index()
                ->comment('Used to indicate those setting that are core to the application');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_setting');
    }
};
