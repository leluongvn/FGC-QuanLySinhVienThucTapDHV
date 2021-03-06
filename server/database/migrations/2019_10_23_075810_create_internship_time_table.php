<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_time', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_internship_type');
            $table->integer('course');
            $table->date('start_time');
            $table->date('end_time');
            $table->date('start_topic')->nullable();
            $table->date('end_topic')->nullable();
            $table->date('start_company')->nullable();
            $table->date('end_company')->nullable();
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
        Schema::dropIfExists('internship_time');
    }
}
