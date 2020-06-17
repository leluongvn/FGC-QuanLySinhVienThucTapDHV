<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Model\Instructor;
use App\Model\Role;
use App\Model\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InstructorController extends Controller
{
    public function getAll($id, $time, $id_subject)
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Trưởng bộ môn") {
            $sub = Teacher::where('id_user', Auth::user()->id)->get();
            $data = DB::table('users as u')
                ->selectRaw('i.id,u.name,u.email,s.mssv,u.phone,s.birthday,s.class,sr.total_point')
                ->join('students as s', 's.id_user', 'u.id')
                ->join('student_reg as sr', 'sr.id_student', 's.id')
                ->join('instructor as i', 'i.id_student_reg', 'sr.id')
                ->where('sr.id_internship_time', $time)
                ->where('sr.id_subject', $sub[0]->id_subject)
                ->where('i.id_teacher', $id)
                ->get();
            return response()->json($data);
        } else if ($role->name === "Admin") {
            $data = DB::table('users as u')
                ->selectRaw('i.id,u.name,u.email,s.mssv,u.phone,s.birthday,s.class,sr.total_point')
                ->join('students as s', 's.id_user', 'u.id')
                ->join('student_reg as sr', 'sr.id_student', 's.id')
                ->join('instructor as i', 'i.id_student_reg', 'sr.id')
                ->where('sr.id_internship_time', $time)
                ->where('sr.id_subject', $id_subject)
                ->where('i.id_teacher', $id)
                ->get();
            return response()->json($data);
        }
    }

    public function getOne($id)
    {
        return response()->json(Instructor::find($id));
    }

    public function create(Request $request)
    {
        foreach ($request->id_student_reg as $item) {
            $instructor = Instructor::create([
                'id_student_reg' => $item,
                'id_teacher' => $request->id_teacher
            ]);
        }
        return response()->json($instructor, 200);
    }

    public function update($id, Request $request)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());

        return 1;
    }

    public function delete($id)
    {
        Instructor::find($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
