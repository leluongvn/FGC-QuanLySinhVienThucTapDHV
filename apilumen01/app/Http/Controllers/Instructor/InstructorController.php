<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Model\Instructor;
use Illuminate\Http\Request;


class InstructorController extends Controller
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

    public function showAllInstructor(){
        //dd("test");
        return response()->json(Instructor::all());
    }

    public function showOneInstructor($id){
        return response()->json(Instructor::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

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
        Instructor::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
