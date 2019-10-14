<?php

namespace App\Http\Controllers\DeTai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\DeTai;

class DeTaiController extends Controller
{

    public function show() {
        return response()->json(DeTai::all());
    }

    public function showOne($id) {
        return response()->json(DeTai::find($id));
    }

    public function create(Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'description'       =>     'required',
                'status'     =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên đề tài',
                'description.required'      => 'Bạn chưa nhập mô tả',
                'status.required'      => 'Bạn chưa nhập trạng thái',
            ]
        );
        $data = DeTai::create($request->all());
        return response()->json($data, 201);
    }
    public function edit($id, Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'description'       =>     'required',
                'status'     =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên đề tài',
                'description.required'      => 'Bạn chưa nhập mô tả',
                'status.required'      => 'Bạn chưa nhập trạng thái',
            ]
        );
        $data = DeTai::where('id',$id);
        if($data->count()==0)
            return response('Edit Failed', 200);
        $data->update($request->all());
        return response()->json($data->get(), 200);
    }

    public function destroy($id){
        $data = DeTai::where('id',$id);
        if($data->count()==0)
            return response('Delete Failed', 200);
        $data->delete();
        return response('Delete Successfully', 200);
    }
    
}
