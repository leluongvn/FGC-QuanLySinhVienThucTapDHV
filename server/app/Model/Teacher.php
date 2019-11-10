<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;

    protected $table='teachers';
    protected $fillable = ['magv','id_subject', 'name','password', 'email','phone','introduce'];

}