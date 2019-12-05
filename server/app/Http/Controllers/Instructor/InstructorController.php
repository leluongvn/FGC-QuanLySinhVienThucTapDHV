<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Model\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InstructorController extends Controller
{
    public function getAll($id, $time, $subject)
    {
        $data = DB::table('users as u')
            ->selectRaw('i.id,u.name,u.email,s.mssv,u.phone,s.birthday,s.class,sr.total_point')
            ->join('students as s', 's.id_user', 'u.id')
            ->join('student_reg as sr', 'sr.id_student', 's.id')
            ->join('instructor as i', 'i.id_student_reg', 'sr.id')
            ->where('sr.id_internship_time', $time)
            ->where('sr.id_subject', $subject)
            ->where('i.id_teacher', $id)
            ->get();
        return response()->json($data);
    }

    public function getOne($id)
    {
        return response()->json(Instructor::find($id));
    }

    public function create(Request $request)
    {
        $instructor = Instructor::create($request->all());
        return response()->json($instructor, 201);
    }

    public function update($id, Request $request)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->all());

        return response()->json($instructor, 200);
    }

    public function delete($id)
    {
        Instructor::find($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
