<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['id_user', 'boss', 'address', 'fields', 'introduce'];

    public function internship()
    {
        return $this->hasMany(Internship_Company::class, 'id_company', 'id');
    }
}