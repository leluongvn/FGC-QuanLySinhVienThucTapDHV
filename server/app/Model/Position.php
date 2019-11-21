<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Position extends Model 
{

    public $timestamps = false;
    protected $primaryKey = 'id';//Mặc định Key là id. nếu muốn KEY khác phải thêm dòng này :D
    protected $table='positions';
    protected $fillable = ['id','id_teacher','id_position_type', 'id_internship_time'];

    
    // public function teacher()
    // {
    //     return $this->belongsTo('App\Internship_Time');
    // }
}
