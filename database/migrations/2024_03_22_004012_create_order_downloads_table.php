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
        Schema::create('order_downloads', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('download_url')->nullable();
            $table->timestamp('downloaded_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->foreign('order_id', 'order_downloads_order_id_fk')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_downloads');
    }
};
