<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student_Reg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getAll($time)
    {
        $data = DB::table('users as u')
            ->select('sr.id', 'sr.id_student', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'sr.total_point', 'u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->where('sr.id_internship_time', $time)
            ->get();

        return $data;
    }

    public function getOne($id)
    {
        $data = DB::table('users as u')
            ->select('sr.id', 'sr.id_student', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'sr.total_point', 'u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->where('sr.id', $id)
            ->get();

        return $data;
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id_student' => 'required|exists:students,id',
                'id_internship_time' => 'required|exists:internship_time,id'
            ]);

        Student_Reg::create($request->all());
        return 1;
    }

    public function update($id, Request $request)
    {
        $this->validate($request,
            [
                'id_student' => 'required|exists:students,id',
                'id_internship_time' => 'required|exists:internship_time,id'
            ]);

        Student_Reg::find($id)->update($request->all());
        return 1;
    }

    public function delete($id)
    {
        Student_Reg::find($id)->delete();
        return 1;
    }
}
