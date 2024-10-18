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
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('booking_id');
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');
                $table->string('lesson_type');
                $table->string('vehicle_registration');
                $table->string('instructor_name');
                $table->decimal('lesson_price', 8, 2);
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
