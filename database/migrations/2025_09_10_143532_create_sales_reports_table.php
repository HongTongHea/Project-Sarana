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
            $table->id();
            $table->string('period_type'); // daily, weekly, monthly, yearly
            $table->string('period_value'); // 2024-01, 2024-W1, 2024, etc.
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_orders');
            $table->decimal('total_subtotal', 15, 2);
            $table->decimal('total_tax_amount', 15, 2);
            $table->decimal('total_discount_amount', 15, 2)->default(0);
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('average_order_value', 15, 2);
            $table->timestamps();

            // Index for quick lookups
            $table->index(['period_type', 'period_value']);
            $table->index(['start_date', 'end_date']);
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
