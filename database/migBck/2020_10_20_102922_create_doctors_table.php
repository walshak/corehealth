<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title_id');
            $table->foreignId('user_id');
            $table->foreignId('status_id')->nullable();
            $table->foreignId('specialization_id')->nullable();
            $table->foreignId('gender_id')->nullable();
            $table->date('date_of_birth');
            $table->string('secondary_email')->unique();
            $table->string('secondary_phone_number')->unique();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('lga_id')->nullable();
            $table->text('contact_address')->nullable();
            $table->text('home_address')->nullable();
            $table->string('consultation_fee')->nullable();
            $table->date('date_of_graduation');
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
        Schema::dropIfExists('doctors');
    }
}
