<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Time extends Model
{
    protected $table = 'internship_time';

    protected $fillable = ['name','id_internship_type','course','start_time','end_time','start_sub_topic','end_sub_topic','start_sub_company','end_sub_company', 'note'];

    public $timestamps = true;

    public function internship_type()
    {
        return $this->belongsTo('App\Internship_Type');
    }
    
    public function topic()
    {
        return $this->hasMany('App\Topic');
    }
}
