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
        Schema::create('invoice_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->string('description');
            $table->decimal('actual_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->decimal('sale_profit', 10, 2)->nullable();
            $table->timestamps();
        
            $table->foreign('quotation_id')->references('id')->on('invoices')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_orders');
    }
};
