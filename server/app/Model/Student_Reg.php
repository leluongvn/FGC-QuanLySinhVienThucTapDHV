<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student_Reg extends Model
{

    protected $table = 'students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_student', 'id_internship_time', 'total_point'];

}
