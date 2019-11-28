<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company_Reg extends Model
{
    protected $table = 'company_reg';

    protected $fillable = ['id_student_reg','id_internship_company'];
}