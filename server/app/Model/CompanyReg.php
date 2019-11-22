<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyReg extends Model
{
    protected $table = 'company_reg';

    protected $fillable = ['id_company','id_internship_time','registration','limit'];
}