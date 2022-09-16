<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursing_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('dependant_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedSmallInteger('nursing_note_type_id');
            $table->longText('note');
            $table->boolean('completed')->default(false);
            $table->integer('status');
            $table->foreign('nursing_note_type_id')->references('id')->on('nursing_note_types');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('dependant_id')->references('id')->on('dependant');
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
        Schema::dropIfExists('nursing_notes');
    }
}
