<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAll()
    {
    
        return response()->json(Student::all());
    }
    public function getSingle($id)
    {
        return response()->json(Student::where('id_student', $id)->first());
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'id_student' => 'required|unique:Student|max:20|min:11',
            'username'   => 'required',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ]);
        $Student = Student::create($request->all());
        return response()->json($Student, 201);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_student' => 'required|unique:Student|max:20|min:11',
            'username'   => 'required',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ]);
        $Student = Student::where('id_Sinhvien', $id)->first();
        $Student->update($request->all());
        return response()->json($Student, 200);
    }
    public function delete($id)
    {
        $Student = Student::where('id_Sinhvien', $id)->first();
        $Student->delete();
        return response('delete complete ', 200);
    }
}
