<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('doctor_id')->nullable();
            $table->foreignId('patient_id')->nullable();
            $table->foreignId('apStatus_id')->nullable();
            $table->string('bookDate');
            $table->text('bookReason');
            $table->tinyInteger('reOccurringStatus');
            $table->string('nextReOccurringDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
