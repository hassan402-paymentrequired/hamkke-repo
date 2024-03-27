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
        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->unsignedBigInteger('customer_id')->index('order_product_customer_index');
            $table->integer('quantity')->index();
            $table->unsignedBigInteger('price')->comment('Unit price in kobo');
            $table->primary(['order_id', 'product_id'], 'order_product_pk');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
