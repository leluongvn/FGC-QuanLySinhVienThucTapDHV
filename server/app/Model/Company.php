<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name', 'password', 'address', 'phone', 'email', 'introduce', 'status'];

    public function internshiptimes()
    {
        return $this->belongsToMany('App\Model\Internship_Time', 'company_reg', 'id_company');
    }
}
