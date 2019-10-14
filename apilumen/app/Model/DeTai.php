<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeTai extends Model
{
    protected $table = 'topic';

    protected $fillable = ['name','description','status'];

    public $timestamps=true;
}
