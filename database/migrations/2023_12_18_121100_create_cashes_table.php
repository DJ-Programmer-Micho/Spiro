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
        Schema::create('cashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->unique()->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->date('cash_date')->nullable();
            $table->json('payments');

            $table->unsignedDecimal('grand_total_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('due_dollar', 12, 0)->default(0);

            $table->unsignedDecimal('grand_total_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('due_iraqi', 18, 0)->default(0);

            $table->string('cash_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashes');
    }
};
