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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('payment_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade');
            $table->date('qoutation_date')->nullable();
            // $table->string('description')->nullable();
            $table->json('services');
            $table->longText('notes')->nullable();

            $table->unsignedDecimal('total_amount_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('tax_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('discount_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('first_pay_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('grand_total_dollar', 12, 0)->default(0);
            $table->unsignedDecimal('due_dollar', 12, 0)->default(0);
            
            $table->unsignedDecimal('total_amount_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('tax_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('discount_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('first_pay_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('grand_total_iraqi', 18, 0)->default(0);
            $table->unsignedDecimal('due_iraqi', 18, 0)->default(0);

            $table->string('exchange_rate')->default(1500);
            $table->string('quotation_status')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
