<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_company');
            $table->integer('id_internship_time');
            $table->integer('limit');
            $table->integer('reg')->nullable();
            $table->string('targets')->nullable();
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
        Schema::dropIfExists('internship_company');
    }
}
