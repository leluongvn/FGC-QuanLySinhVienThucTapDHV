<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->increments('id',20)->unique();
            // $table->string('id_subject',20)->unique();
            // $table->string('id_subject',20);    
            $table->string('name',255);
            $table->string('password',255);
            $table->date('date_birth');
            $table->boolean('gender');
            $table->string('phone');
            $table->string('address');
            $table->string('email');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('teacher');
    }
}
