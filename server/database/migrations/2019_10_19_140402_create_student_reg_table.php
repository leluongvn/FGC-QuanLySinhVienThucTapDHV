<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD:apilumen/database/migrations/2019_10_19_140402_create_student_regs_table.php
        Schema::create('student_regs', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('student_id');
            $table->integer('internship_time_id');
            $table->string('note',255)->nullable();
=======
        Schema::create('student_reg', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('id_student');
            $table->integer('id_internship_time');
            $table->integer('total_point');
>>>>>>> d44c6cc80fa912ae9cec2998ea4e7e10f22a8669:server/database/migrations/2019_10_19_140402_create_student_reg_table.php
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
        Schema::dropIfExists('student_reg');
    }
}
