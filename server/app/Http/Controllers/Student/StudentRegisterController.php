<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Student;
use App\Model\StudentReg;
use Illuminate\Support\Facades\DB;

class StudentRegisterController extends Controller
{
    public function getAll($id)
    {
        $data = DB::table('student_reg')
            ->select('student_reg.id', 'students.mssv', 'students.name', 'students.class', 'students.date_birth', 'students.phone', 'students.email', 'student_reg.total_point')
            ->join('students', 'students.id', 'student_reg.id_student')
            ->where('student_reg.id_internship_time', $id)
            ->get();

        return response()->json($data);
    }

    public function getOne($id){
        return StudentReg::find($id);
    }

    public function create(Request $request)
    {
        StudentReg::create($request->all());
        return 1;
    }

    public function update ($id, Request $request){
        StudentReg::find($id)->update($request->all());
        return 1;
    }

    public function delete($id){
        StudentReg::find($id)->delete();
        return 1;
    }
}
