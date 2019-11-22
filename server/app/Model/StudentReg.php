<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentReg extends Model
{

    protected $table = 'student_reg';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_student', 'id_internship_time', 'total_point'];
}
