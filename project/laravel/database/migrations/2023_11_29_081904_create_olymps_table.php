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
    {/*
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('id_teacher');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->integer('flag');
            $table->timestamps();
        });
        Schema::create('teacher', function (Blueprint $table) {
            $table2->id();
            $table2->string('name');
            $table2->string('surname');
          //  $table->string('email');
            $table2->integer('flag');
            $table2->integer('school');
            $table2->string('url');
            $table2->timestamps();
        });
        Schema::create('school', function (Blueprint $table) {
            $table3->id();
            $table3->string('name');
            $table3->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('olymps');
    }
};
