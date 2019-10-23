<?php

namespace App\Http\Controllers\Specialized;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Specialized;

class SpecializedController extends Controller
{

    public function show() {
        return response()->json(Specialized::all());
    }

    public function showOne($id) {
        return response()->json(Specialized::find($id));
    }

    public function create(Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
                'id_academy' => 'required|exists:academy,id'
            ], [
                'name.required'      => 'Bạn chưa nhập tên khoa',
                'id_academy.required'=>'Bạn chưa chọn viện',
                'id_academy.exists' => 'Không tồn tại viện đã chọn'
            ]
        );
        $data = Specialized::create($request->all());
        return response()->json($data, 201);
    }
    public function edit($id, Request $request){
        $this->validate(
            $request,[
                'name'       =>     'required',
                'id_academy' => 'required|exists:academy,id'
            ], [
                'name.required'      => 'Bạn chưa nhập tên khoa',
                'id_academy.required'=>'Bạn chưa chọn viện',
                'id_academy.exists' => 'Không tồn tại viện đã chọn'
            ]
        );
        $data = Specialized::where('id',$id);
        if($data->count()==0)
            return response('Edit Failed', 400);
        $data->update($request->all());
            return response()->json($data->get(), 200);
    }

    public function destroy($id){
        $data = Specialized::where('id',$id);
        if($data->count()==0)
            return response('Delete Failed', 400);
        $data->delete();
        return response('Delete Successfully', 200);
    }
    
}
