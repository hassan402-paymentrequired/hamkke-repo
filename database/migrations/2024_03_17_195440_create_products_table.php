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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique('products_slug_unique');
            $table->text('description');
            $table->unsignedBigInteger('price')->comment('Price in kobo');
            $table->unsignedBigInteger('price_in_cents')->nullable()->comment('Price in cents');
            $table->string('product_image');
            $table->unsignedInteger('product_category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_category_id', 'product_category_id_foreign')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
