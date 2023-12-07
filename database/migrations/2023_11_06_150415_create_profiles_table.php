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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('job_title');
            $table->string('national_id')->unique();
            $table->string('avatar')->nullable();
            $table->string('phone_number_1');
            $table->string('phone_number_2')->nullable();
            $table->string('email_address')->nullable();
            $table->string('salary_dollar');
            $table->string('salary_iraqi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
