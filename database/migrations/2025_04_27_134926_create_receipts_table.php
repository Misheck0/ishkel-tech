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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method')->nullable(); // Example: 'Paystack', 'Bank Transfer', 'Cash'
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_number')->unique(); // e.g., "REC-2025-001"
            $table->text('notes')->nullable(); // optional "Thank you for your payment."
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['invoice_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
