<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_payrolls_table.php
public function up()
{
    Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->decimal('monthly_salary', 12, 2);
        $table->integer('days_worked')->default(0);
        $table->decimal('overtime_hours', 8, 2)->default(0);
        $table->decimal('overtime_rate', 10, 2)->default(0);
        $table->decimal('total_earnings', 12, 2)->nullable();
        $table->date('pay_period_start');
        $table->date('pay_period_end');
        $table->decimal('net_salary', 10, 2)->nullable();
        $table->boolean('is_paid')->default(false);
        $table->timestamps();
    });

    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->date('date');
        $table->boolean('present')->default(false);
        $table->decimal('overtime_hours', 8, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
