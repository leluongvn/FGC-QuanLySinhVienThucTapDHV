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
    protected $fillable = ['mssv','name','password','class','email','date_birth','phone','note'];

}
