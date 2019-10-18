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
        'username','first_name','last_name','email','gender','address','phone', 'class_id', 'school_year','note'
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
