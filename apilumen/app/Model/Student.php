<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Student extends Model 
{

    protected $table = 'students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_student','course_id','first_name','last_name','email','gender','address','phone','date_birth', 'class','note','password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
