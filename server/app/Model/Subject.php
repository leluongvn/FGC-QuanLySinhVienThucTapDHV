<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Subject extends Model 
{

    protected $table = 'subjects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','id_specialized','name','note'];
    
    // public function teacher()
    // {
    //     return $this->belongsTo('App\Internship_Time');
    // }
}
