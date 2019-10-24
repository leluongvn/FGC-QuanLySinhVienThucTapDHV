<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class StudentReg extends Model 
{

    protected $table = 'student_regs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id','internship_time_id','note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
         'password'
    ];
}
