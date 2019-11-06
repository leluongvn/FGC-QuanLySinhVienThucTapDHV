<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Student;
use App\Model\StudentReg;
class StudentRegisterController extends Controller
{
    public function create(Request $request)
    {
        /**
         * Thêm mới các sinh viên đăng ký thực tập
         */

        if (count($request->json()->all())) {
            $students     = $request->json()->all();
            foreach($students as $value){
                StudentReg::create([
                    'student_id'         => $value['student_id'],
                    'note'               => $value['note'],
                    'internship_time_id' => $value['intership_time_id'],
                ]);
            }
        }
    }
}
