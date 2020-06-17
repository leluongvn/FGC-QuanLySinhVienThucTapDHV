<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Student;
use App\Model\Student_Reg;
use App\Model\Teacher;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function regExcel(Request $request, $id)
    {
        try {
            foreach ($request->data as $item) {

                $user = User::updateOrCreate(['email' => $item['Email']], ['name' => $item['Tên sinh viên'], 'id_role' => 6, 'password' => app('hash')->make($item['Mã sinh viên'])]);
                $student = Student::updateOrCreate(['mssv' => $item['Mã sinh viên']], ['id_user' => $user->id, 'class' => $item['Lớp']]);
                Student_Reg::create([
                    'id_student' => $student->id,
                    'id_internship_time' => $id
                ]);
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function pbm(Request $request)
    {
        $this->validate($request,
            [
                'id_subject' => 'required|exists:subjects,id',
                'student' => 'required',
            ],
            [
                'id_subject.required' => 'Bộ môn không tồn tại',
                'student.required' => 'Bạn chưa chọn sinh viên',
            ]
        );

        foreach ($request->student as $val) {
            Student_Reg::find($val['id'])->update([
                'id_subject' => $request->id_subject
            ]);
        }

        return 1;
    }

    public function getNotReg($time)
    {
        $data = DB::table('users as u')
            ->selectRaw('sr.id, sr.id_student, s.id_user,u.name, u.email, u.phone, s.mssv, DATE_FORMAT(s.birthday, "%d/%m/%Y") as birthday, s.class, sr.total_point, u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->where('sr.id_internship_time', $time)
            ->where('sr.id_subject', 0)
            ->get();
        return $data;
    }

    public function getAll($time, $subject)
    {
        if ($subject == 0) {
            $data = DB::table('users as u')
                ->selectRaw('sr.id, sr.id_student, s.id_user,u.name, u.email, u.phone, s.mssv, DATE_FORMAT(s.birthday, "%d/%m/%Y") as birthday, s.class, sr.total_point, u.status')
                ->join('students as s', 's.id_user', 'u.id')
                ->join('student_reg as sr', 'sr.id_student', 's.id')
                ->where('sr.id_internship_time', $time)
                ->get();
        } else {
            $data = DB::table('users as u')
                ->selectRaw('sr.id, sr.id_student, s.id_user,u.name, u.email, u.phone, s.mssv, DATE_FORMAT(s.birthday, "%d/%m/%Y") as birthday, s.class, sr.total_point, u.status')
                ->join('students as s', 's.id_user', 'u.id')
                ->join('student_reg as sr', 'sr.id_student', 's.id')
                ->where('sr.id_internship_time', $time)
                ->where('sr.id_subject', $subject)
                ->get();
        }

        return $data;
    }

    public function getNotInstructor($time, $subject)
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Trưởng bộ môn") {
            $sub = Teacher::where('id_user', Auth::user()->id)->get();
            $data = DB::select("SELECT sr.id,concat(s.mssv,' - ', u.name) as 'name' ,u.email,u.phone,s.birthday,s.class,sr.total_point 
            from users u join students s on s.id_user=u.id
            JOIN student_reg sr on sr.id_student=s.id
            WHERE sr.id_internship_time = ? and sr.id_subject = ?
            AND sr.id NOT in (SELECT i.id_student_reg from instructor i)", [$time, $sub[0]->id_subject]);
        } else if ($role->name === "Admin") {
            $data = DB::select("SELECT sr.id,concat(s.mssv,' - ', u.name) as 'name' ,u.email,u.phone,s.birthday,s.class,sr.total_point 
            from users u join students s on s.id_user=u.id
            JOIN student_reg sr on sr.id_student=s.id
            WHERE sr.id_internship_time = ? and sr.id_subject = ?
            AND sr.id NOT in (SELECT i.id_student_reg from instructor i)", [$time, $subject]);
        }


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

        Student_Reg::create($request->all());
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
        $user = Student_Reg::find($id);
        if (sizeof($user->instructor) <= 0 && sizeof($user->point) <= 0 && sizeof($user->company) <= 0) {
            $user->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }
    }
}
