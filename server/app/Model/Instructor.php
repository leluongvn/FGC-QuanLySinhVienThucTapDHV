<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'instructor';
    protected $fillable = ['id_student_reg', 'id_teacher','status'];

}