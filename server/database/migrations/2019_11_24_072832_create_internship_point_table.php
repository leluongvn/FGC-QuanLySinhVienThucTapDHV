<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_point', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_internship_topic');
            $table->string('product');
            $table->string('teacher_comment')->nullable();
            $table->string('company_comment')->nullable();
            $table->integer('teacher_point')->nullable();
            $table->integer('company_point')->default(0);
            $table->integer('total_point')->default(0);
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
        Schema::dropIfExists('internship_point');
    }
}
