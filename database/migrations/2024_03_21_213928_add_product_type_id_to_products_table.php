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
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('product_type')->after('product_category_id')->index('products_product_type_index');
            $table->text('electronic_product_url')->nullable()->after('product_type');
            $table->text('class_registration_url')->nullable()->after('product_type');
        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_type');
            $table->dropColumn('electronic_product_url');
            $table->dropColumn('class_registration_url');
        });
    }
};
