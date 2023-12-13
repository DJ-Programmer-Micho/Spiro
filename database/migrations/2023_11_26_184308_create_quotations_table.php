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
            $table->string('description')->nullable();
            $table->json('services')->nullable();
            $table->json('notes')->nullable();

            $table->string('total_amount_dollar')->nullable();
            $table->string('tax_dollar')->nullable();
            $table->string('discount_dollar')->nullable();
            $table->string('first_pay_dollar')->nullable();
            $table->string('grand_total_dollar')->nullable();
            $table->string('due_dollar')->nullable();
            
            $table->string('total_amount_iraqi')->nullable();
            $table->string('tax_iraqi')->nullable();
            $table->string('discount_iraqi')->nullable();
            $table->string('first_pay_iraqi')->nullable();
            $table->string('grand_total_iraqi')->nullable();
            $table->string('due_iraqi')->nullable();

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
