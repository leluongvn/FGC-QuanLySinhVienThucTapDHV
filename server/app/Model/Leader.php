<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class Leader extends Model 
{

    protected $table = 'leaders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_student_reg','id_position'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
}
