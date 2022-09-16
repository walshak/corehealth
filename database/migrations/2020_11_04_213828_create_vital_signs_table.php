<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('receptionist_id');
            $table->foreignId('nurse_id')->nullable();
            $table->foreignId('medical_report_id')->nullable();
            $table->string('temperature');
            $table->string('weight');
            $table->string('bloodPressure');
            $table->text('VitalSignReport');
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
        Schema::dropIfExists('vital_signs');
    }
}
