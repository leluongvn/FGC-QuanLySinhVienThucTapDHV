<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student_Reg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getAll($time, $subject)
    {
        $data = DB::table('users as u')
            ->select('sr.id', 'sr.id_student', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'sr.total_point', 'u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->where('sr.id_internship_time', $time)
            ->where('sr.id_subject', $subject)
            ->get();

        return $data;
    }

    public function getNotInstructor($time, $subject)
    {
        $a = DB::select("SELECT sr.id,u.name,u.email,s.mssv,u.phone,s.birthday,s.class,sr.total_point 
            from users u join students s on s.id_user=u.id
            JOIN student_reg sr on sr.id_student=s.id
            WHERE sr.id_internship_time = ? and sr.id_subject = ?
            AND sr.id NOT in (SELECT i.id_student_reg from instructor i)", [$time, $subject]);
        // $data = DB::table('users as u')
        //     ->select('sr.id', 'sr.id_student', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'sr.total_point', 'u.status')
        //     ->join('students as s', 's.id_user', 'u.id')
        //     ->join('student_reg as sr', 'sr.id_student', 's.id')
        //     ->where('sr.id_internship_time', $time)
        //     ->where('sr.id_subject', $subject)
        //     ->get();

        return $a;
    }

    public function getOne($id)
    {
        $data = DB::table('users as u')
            ->select('sr.id', 'sr.id_student', 'id_internship_time', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'sr.total_point', 'u.status')
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
                'id_internship_time' => 'required|exists:internship_time,id',
                'total_point' => 'required|max:4|min:0'
            ],
            [
                'id_student.required' => 'Thất bại, Mời chọn sinh viên',
                'id_student.exists' => 'Thất bại, Sinh viên này không tồn tại',
                'id_internship_time.required' => 'Thất bại, Mời chọn thời gian thực tập',
                'id_internship_time.exists' => 'Thất bại, Thời gian thực tâp không tồn tại',
                'total_point.max' => 'Thất bại, Điểm hệ 4 phải lớn hơn hoặc bằng 0',
                'total_point.min' => 'Thất bại, Điểm hệ 4 phải nhỏ hơn hoặc bằng 4',
            ]
        );

        Student_Reg::create($request->all());
        return 1;
    }

    public function update($id, Request $request)
    {
        $this->validate($request,
            [
                'id_student' => 'required|exists:students,id',
                'id_internship_time' => 'required|exists:internship_time,id',
                'total_point' => 'required|max:4|min:0'
            ],
            [
                'id_student.required' => 'Thất bại, Mời chọn sinh viên',
                'id_student.exists' => 'Thất bại, Sinh viên này không tồn tại',
                'id_internship_time.required' => 'Thất bại, Mời chọn thời gian thực tập',
                'id_internship_time.exists' => 'Thất bại, Thời gian thực tâp không tồn tại',
                'total_point.max' => 'Thất bại, Điểm hệ 4 phải lớn hơn hoặc bằng 0',
                'total_point.min' => 'Thất bại, Điểm hệ 4 phải nhỏ hơn hoặc bằng 4',
            ]
        );

        Student_Reg::find($id)->update($request->all());
        return 1;
    }

    public function delete($id)
    {
        Student_Reg::find($id)->delete();
        return 1;
    }
}
