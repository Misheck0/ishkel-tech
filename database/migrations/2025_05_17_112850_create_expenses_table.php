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
// database/migrations/xxxx_xx_xx_create_expenses_table.php
public function up()
{
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->decimal('amount', 12, 2);
        $table->string('category')->nullable();
        $table->text('description')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who recorded it
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
