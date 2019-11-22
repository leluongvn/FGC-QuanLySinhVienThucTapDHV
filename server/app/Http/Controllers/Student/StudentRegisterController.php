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

    public function create(Request $request)
    {
        /**
         * Thêm mới các sinh viên đăng ký thực tập
         */

        if (count($request->json()->all())) {
            $students = $request->json()->all();
            foreach ($students as $value) {
                StudentReg::create([
                    'student_id' => $value['student_id'],
                    'note' => $value['note'],
                    'internship_time_id' => $value['intership_time_id'],
                ]);
            }
        }
    }
}
