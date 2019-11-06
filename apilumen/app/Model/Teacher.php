<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;

    protected $table='teacher';
    protected $fillable = [
        'id_subject', 'name','password', 'email','phone','introduce'
    ];

}