<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatestudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('id_student',20)->unique();
            $table->string('username',20)->unique();
            $table->string('password',30);
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('email',30)->nullable();
            $table->boolean('gender')->nullable();
            $table->string('address',255)->nullable();
            $table->string('phone',11)->nullable();
            $table->string('note',255)->nullable();
            $table->smallInteger('shool_year')->nullable();
            $table->mediumInteger('class_id');
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
        Schema::dropIfExists('students');
    }
}
