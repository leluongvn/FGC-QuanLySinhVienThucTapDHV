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
            $table->increments('id');
            $table->string('id_student',20);
            $table->integer('course_id');
            $table->string('name',255);        
            $table->string('password',255);
            $table->string('class',255);
            $table->string('email',255);            
            $table->date('date_birth');
            $table->string('phone',12);                    
            $table->text('note')->nullable();
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
