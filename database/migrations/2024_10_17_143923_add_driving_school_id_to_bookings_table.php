<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->foreignId('driving_school_id')->constrained('driving_schools');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['driving_school_id']);
        $table->dropColumn('driving_school_id');
    });
}

};
