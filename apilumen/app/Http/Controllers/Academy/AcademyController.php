<?php

namespace App\Http\Controllers\Academy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Academy;

class AcademyController extends Controller
{

    public function show() {
        return response()->json(Academy::all());
    }

    public function showOne($id) {
        return response()->json(Academy::find($id));
    }

    public function create(Request $request){
        $this->validate(
            $request,[
                'name'        =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên viện',
            ]
        );
        $data = Academy::create($request->all());
        return response()->json($data, 201);
    }
    public function edit($id, Request $request){
        $this->validate(
            $request,[
                'name'       =>     'required',
            ], [
                'name.required'      => 'Bạn chưa nhập tên viện',
            ]
        );
        $data = Academy::where('id',$id);
        if($data->count()==0)
            return response('Edit Failed', 400);
        $data->update($request->all());
            return response()->json($data->get(), 200);
    }

    public function destroy($id){
        $data = Academy::where('id',$id);
        if($data->count()==0)
            return response('Delete Failed', 400);
        $data->delete();
        return response('Delete Successfully', 200);
    }
    
}
