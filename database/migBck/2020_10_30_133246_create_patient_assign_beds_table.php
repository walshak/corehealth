<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAssignBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_assign_beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_user_id');
            $table->foreignId('medical_report_id');
            $table->foreignId('ward_id');
            $table->foreignId('bed_id');
            $table->text('bedCharges');
            $table->text('numberDays');
            $table->text('disChargeDate');
            $table->text('amountPaid');
            $table->integer('partPayment');
            $table->integer('discountPayment');
            $table->integer('payment_status');
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
        Schema::dropIfExists('patient_assign_beds');
    }
}
