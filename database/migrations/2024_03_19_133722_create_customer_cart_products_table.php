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
        Schema::create('customer_cart_products', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->unsignedInteger('product_id');
            $table->integer('quantity')->index();
            $table->unsignedBigInteger('price')->comment('Price in kobo');
            $table->timestamps();
            $table->primary(['customer_id','product_id'], 'customer_cart_pk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_cart_products');
    }
};
