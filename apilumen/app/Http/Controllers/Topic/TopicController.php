<?php

namespace App\Http\Controllers\Topic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Topic;

class TopicController extends Controller
{

    public function show() {
        return response()->json(Topic::all());
    }

    public function showOne($id) {
        return response()->json(Topic::find($id));
    }

    public function create(Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'id_internship_time' => 'required|exists:specialized,id',
                'creator'        =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên đề tài',
                'id_internship_time.required'=>'Bạn chưa chọn loại thực tập',
                'id_internship_time.exists' => 'Không tồn tại loại thực tập đã chọn',
                'creator.required'      => 'Bạn chưa nhập tên người tạo'
            ]
        );
        $Topic = Topic::create($request->all());
        return response()->json($Topic, 201);
    }
    public function edit($id, Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'id_internship_time' => 'required|exists:specialized,id',
                'creator'        =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên đề tài',
                'id_internship_time.required'=>'Bạn chưa chọn loại thực tập',
                'id_internship_time.exists' => 'Không tồn tại loại thực tập đã chọn',
                'creator.required'      => 'Bạn chưa nhập tên người tạo'
            ]
        );
        $Topic = Topic::where('id',$id);
        if($Topic->count()==0)
            return response('Edit Failed', 200);
        $Topic->update($request->all());
        return response()->json($Topic->get(), 200);
    }

    public function destroy($id){
        $Topic = Topic::where('id',$id);
        if($Topic->count()==0)
            return response('Delete Failed', 200);
        $Topic->delete();
        return response('Delete Successfully', 200);
    }
    
}
