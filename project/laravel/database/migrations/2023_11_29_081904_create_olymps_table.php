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
            $table->id();
            $table->string('name');
            $table->string('surname');
          //  $table->string('email');
            $table->integer('flag');
            $table->integer('school');
            $table->string('url');
            $table->timestamps();
        });
       /* Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
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
