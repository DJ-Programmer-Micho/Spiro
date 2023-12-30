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
        Schema::create('emp_tasks', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('invoice_id')->unique()->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');            $table->json('tasks');
            $table->unsignedInteger('progress')->default(0);
            $table->string('task_status');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_tasks');
    }
};
