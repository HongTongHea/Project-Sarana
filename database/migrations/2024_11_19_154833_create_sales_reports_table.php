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
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->unsignedBigInteger('customer_id'); // Foreign key to customers table
            $table->decimal('total_sales', 10, 2); // Total sales for the product by customer
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_reports');
    }
};
