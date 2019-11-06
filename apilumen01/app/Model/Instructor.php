<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    public $timestamps = false;

    protected $table='instructor';
    protected $fillable = [
        'id', 'id_student_reg', 'id_teacher','note',
    ];

}