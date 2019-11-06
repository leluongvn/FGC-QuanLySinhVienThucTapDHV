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
        'id_student','name','password','class','email','date_birth','phone','note'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
