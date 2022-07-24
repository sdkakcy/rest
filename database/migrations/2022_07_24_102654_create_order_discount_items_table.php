<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_discount_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_discount_id');
            $table->string('discount_reason');
            $table->decimal('discount_amount');
            $table->decimal('subtotal');
            $table->timestamps();

            $table->foreign('order_discount_id')->on('order_discounts')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_discount_items');
    }
};
