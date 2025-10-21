<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockable_id');
            $table->string('stockable_type');
            $table->integer('quantity')->default(0);
            $table->integer('initial_quantity')->default(0);
            $table->string('type')->default('purchase');
            $table->integer('change_amount')->default(0);
            $table->timestamps();

            // Index for better performance
            $table->index(['stockable_id', 'stockable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
