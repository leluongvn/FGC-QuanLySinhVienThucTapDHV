<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $fillable = ['name','id_specialized', 'note'];

    public $timestamps = true;

    public function specialized()
    {
        return $this->belongsTo('App\Specialized');
    }
    
    public function internship_time()
    {
        return $this->hasMany('App\Internship_Time');
    }
}
