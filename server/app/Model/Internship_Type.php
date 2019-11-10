<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Type extends Model
{
    protected $table = 'internship_type';

    protected $fillable = ['name','status'];

    public $timestamps = true;

    public function internship_time()
    {
        return $this->hasMany('App\Internship_Time');
    }
}
