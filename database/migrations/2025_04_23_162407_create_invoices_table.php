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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // prepare by
            $table->foreignId('customer_id')->nullable()->constrained('customer')->onDelete('set null');
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->decimal('total_amount',10,2)->default(0);
            $table->enum('status',['paid','unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
