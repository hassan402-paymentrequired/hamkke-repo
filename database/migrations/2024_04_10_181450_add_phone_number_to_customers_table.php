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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone')->after('email')->nullable();
            $table->unsignedInteger('country_id')->after('email')->nullable();

            $table->foreign('country_id', 'customers_country_id_foreign')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropForeign('customers_country_id_foreign');
            $table->dropColumn('country_id');
        });
    }
};
