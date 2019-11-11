<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Position_Type extends Model
{
    protected $table = 'position_type';

    protected $fillable = ['name'];

    public $timestamps = true;
}
