<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyRegList extends Model
{ 
    protected $table = 'company_reg_list';

    protected $fillable = ['id_student_reg','id_company_reg'];
}
