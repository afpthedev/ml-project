<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->longText('profile_picture')->nullable(); // Base64 kodlu resim verisi
            $table->string('first_name'); // Öğrencinin ismi
            $table->string('last_name'); // Öğrencinin soyismi
            $table->string('email')->unique(); // Öğrencinin e-posta adresi
            $table->string('student_number')->unique(); // Öğrenci numarası
            $table->string('mother_name')->nullable(); // Anne ismi
            $table->string('father_name')->nullable(); // Baba ismi
            $table->string('city'); // Okuduğu il
            $table->string('district'); // Okuduğu ilçe
            $table->string('school_name'); // Okuduğu okul
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
