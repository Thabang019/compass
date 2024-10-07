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
        Schema::create('driving_schools', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('school_name');
            $table->string('phone_number');
            $table->string('image')->nullable();
            $table->string('location');
            $table->decimal('suburb');
            $table->decimal('city');
            $table->string('certificate');
            $table->string('status')->nullable()->default('pending');
            $table->decimal('price_per_lesson', 8, 2);  // Add price per lesson
            $table->json('working_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_schools');
    }
};
