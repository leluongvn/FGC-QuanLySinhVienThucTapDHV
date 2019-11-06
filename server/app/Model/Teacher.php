<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
   

    protected $table='teacher';
    protected $fillable = [
        'id_subject', 'name','password','date_birth','gender','phone','address','email','note'
    ];

}