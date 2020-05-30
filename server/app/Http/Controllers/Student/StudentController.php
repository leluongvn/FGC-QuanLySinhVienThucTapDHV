<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\Student_Reg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getAll($time, $subject)
    {
        $data = DB::table('users as u')
            ->selectRaw('sr.id, sr.id_student, s.id_user,u.name, u.email, u.phone, s.mssv, DATE_FORMAT(s.birthday, "%d/%m/%Y") as birthday, s.class, sr.total_point, u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->where('sr.id_internship_time', $time)
            ->where('sr.id_subject', $subject)
            ->get();

        return $data;
    }

    public function getNotInstructor($time, $subject)
    {
        $data = DB::select("SELECT sr.id,concat(s.mssv,' - ', u.name) as 'name' ,u.email,u.phone,s.birthday,s.class,sr.total_point 
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

        return $data;
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
                'id_student' => 'required',
                'id_internship_time' => 'required|exists:internship_time,id',
            ],
            [
                'id_student.required' => 'Thất bại, Mời chọn sinh viên',
                'id_internship_time.required' => 'Thất bại, Mời chọn thời gian thực tập',
                'id_internship_time.exists' => 'Thất bại, Thời gian thực tâp không tồn tại',
            ]
        );

        foreach ($request->id_student as $val) {
            Student_Reg::create([
                'id_student' => $val,
                'id_internship_time' => $request->id_internship_time,
                'id_subject' => $request->id_subject
            ]);
        }

        return 1;
    }

    public function update($id, Request $request)
    {
        $this->validate($request,
            [
                'id_student' => 'required',
                'id_internship_time' => 'required|exists:internship_time,id',
                'total_point' => 'required|max:4|min:0'
            ],
            [
                'id_student.required' => 'Thất bại, Mời chọn sinh viên',
                'id_internship_time.required' => 'Thất bại, Mời chọn thời gian thực tập',
                'id_internship_time.exists' => 'Thất bại, Thời gian thực tâp không tồn tại',
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
