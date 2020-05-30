<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_user', 'mssv', 'birthday', 'class'];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'id_user', 'id');
    }

    public function reg()
    {
        return $this->hasMany(Student_Reg::class, 'id_student', 'id');
    }

    public function detail()
    {
        return $this->hasManyThrough(View_Profile::class, Student_Reg::class, 'id_student', 'id');
    }

}
