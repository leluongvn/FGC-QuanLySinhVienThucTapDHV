<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Model\Teacher;
use Illuminate\Http\Request;


class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function showAllTeachers(){
        //dd("test");
        return response()->json(Teacher::all());
    }

    public function showOneTeachers($id){
        return response()->json(Teacher::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            
            'name' => 'required'
        ]);

        $teacher = Teacher::create($request->all());

        return response()->json($teacher, 201);
    }

    public function update($id, Request $request)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());

        return response()->json($teacher, 200);
    }

    public function delete($id)
    {
        Teacher::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
