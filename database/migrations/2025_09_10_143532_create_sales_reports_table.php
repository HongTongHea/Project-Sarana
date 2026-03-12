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
            $table->enum('report_type', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('total_orders');
            $table->decimal('total_sales', 15, 2);
            $table->decimal('total_tax', 15, 2);
            $table->decimal('average_order_value', 15, 2);
            $table->json('report_data')->nullable(); // For storing detailed breakdown
            $table->timestamps();

            $table->index(['report_type', 'start_date']);
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
