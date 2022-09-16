<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientLabServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_lab_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_user_id')->nullable();
            $table->foreignId('lab_user_id')->nullable();
            $table->foreignId('medical_report_id')->nullable();
            $table->foreignId('lab_id')->nullable();
            $table->foreignId('lab_service_id')->nullable();
            $table->integer('payment_status');
            $table->integer('status_id');
            $table->integer('sampeTaken');
            $table->string('sampeDate');
            $table->longText('resultReport');
            $table->string('resultDate');
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
        Schema::dropIfExists('patient_lab_services');
    }
}
