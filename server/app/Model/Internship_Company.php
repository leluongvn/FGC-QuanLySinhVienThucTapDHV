<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Company extends Model
{
    protected $table = 'Internship_Company';

    protected $fillable = ['id_company','id_internship_time','limit','reg'];
}