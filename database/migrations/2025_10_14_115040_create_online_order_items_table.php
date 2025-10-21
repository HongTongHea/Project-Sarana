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
        Schema::create('online_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_order_id')->constrained()->onDelete('cascade');

            // Polymorphic relationship
            $table->string('item_type'); // 'App\Models\Product' or 'App\Models\Accessory'
            $table->unsignedBigInteger('item_id');

            // Item details
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discounted_price', 10, 2);
            $table->decimal('total_price', 10, 2);

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
        Schema::dropIfExists('online_order_items');
    }
};
