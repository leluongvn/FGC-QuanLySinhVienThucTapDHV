<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = ['name','id_internship_time','creator','note'];

    public $timestamps=true;

    // public function internship_time()
    // {
    //     return $this->belongsTo('App\Internship_Time');
    // }
}
