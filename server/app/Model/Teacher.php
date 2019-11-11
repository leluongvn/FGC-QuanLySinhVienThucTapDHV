<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;

    protected $table='teachers';
    protected $fillable = ['msgv','id_subject', 'name','password', 'email','phone','introduce'];

}