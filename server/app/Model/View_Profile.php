<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class View_Profile extends Model
{
    protected $table = 'view_profile';

    protected $fillable = ['internship_time', 'teacher_id', 'teacher_name', 'company_id', 'company_name'];

    public function reg()
    {
        return $this->hasOne(Student_Reg::class, 'id', 'id');
    }

    public function point()
    {
        return $this->belongsTo(Internship_Point::class, 'id', 'id_student_reg');
    }
}
