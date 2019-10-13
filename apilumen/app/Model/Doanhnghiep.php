<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Doanhnghiep extends Model
{
    protected $table = 'enterprise';

    protected $fillable = ['name','address','phone','email','introduce'];

}
