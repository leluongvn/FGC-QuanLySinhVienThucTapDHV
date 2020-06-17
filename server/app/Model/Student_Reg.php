<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student_Reg extends Model
{

    protected $table = 'student_reg';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_student', 'id_subject', 'id_internship_time', 'total_point'];

    public function profile()
    {
        return $this->hasOne(View_Profile::class, 'id', 'id');
    }

    public function point()
    {
        return $this->hasOne(Internship_Point::class, 'id_student_reg', 'id');
    }

    public function internship()
    {
        return $this->belongsTo(Internship_Time::class, 'id_internship_time', 'id');
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'id_student_reg', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company_Reg::class, 'id_student_reg', 'id');
    }
}
