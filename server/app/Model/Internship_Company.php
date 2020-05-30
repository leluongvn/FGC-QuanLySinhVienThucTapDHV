<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Company extends Model
{
    protected $table = 'Internship_Company';

    protected $fillable = ['id_company', 'id_internship_time', 'limit', 'reg'];

    public function reg()
    {
        return $this->hasMany('App\Model\Company_Reg', 'id_internship_company', 'id');
    }
}