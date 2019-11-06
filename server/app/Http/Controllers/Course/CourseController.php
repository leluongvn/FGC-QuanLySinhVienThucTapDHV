<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;

class CourseController extends Controller
{

    public function show() {
        return response()->json(Course::all());
    }

    public function showOne($id) {
        return response()->json(Course::find($id));
    }

    public function create(Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'id_specialized' => 'required|exists:specialized,id'
            ], [
                'name.required'      => 'Bạn chưa nhập tên khóa',
                'id_specialized.required'=>'Bạn chưa chọn khoa',
                'id_specialized.exists' => 'Không tồn tại khoa đã chọn'
            ]
        );
        $data = Course::create($request->all());
        return response()->json($data, 201);
    }
    public function edit($id, Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'id_specialized' => 'required|exists:specialized,id'
            ], [
                'name.required'      => 'Bạn chưa nhập tên khóa',
                'id_specialized.required'=>'Bạn chưa chọn khoa',
                'id_specialized.exists' => 'Không tồn tại khoa đã chọn'
            ]
        );
        $data = Course::where('id',$id);
        if($data->count()==0)
            return response('Edit Failed', 400);
        $data->update($request->all());
            return response()->json($data->get(), 200);
    }

    public function destroy($id){
        $data = Course::where('id',$id);
        if($data->count()==0)
            return response('Delete Failed', 400);
        $data->delete();
        return response('Delete Successfully', 200);
    }
    
}
