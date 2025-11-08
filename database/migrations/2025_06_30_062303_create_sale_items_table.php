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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');

            // Polymorphic relationship fields
            $table->string('item_type'); // Will store 'App\Models\Product' or 'App\Models\Accessory'
            $table->unsignedBigInteger('item_id'); // Will store product_id or accessory_id

            // Item details
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Original price
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discounted_price', 10, 2); // Price after discount
            $table->decimal('total', 10, 2); // Quantity × discounted_price

            $table->timestamps();

            // Index for polymorphic relationship
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
