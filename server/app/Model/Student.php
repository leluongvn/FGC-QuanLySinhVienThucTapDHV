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
    protected $fillable = ['id_user', 'mssv', 'birthday', 'class'];

}
