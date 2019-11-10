<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Type;

class Internship_TypeController extends Controller
{

    public function show()
    {
        return response()->json(Internship_Type::all());
    }

    public function showOne($id)
    {
        return response()->json(Internship_Type::find($id));
    }

    public function create(Request $request)
    {
        $this->validate(
            $request, [
            'name' => 'required',
//            'id_specialized' => 'required|exists:specialized,id'
        ], [
                'name.required' => 'Bạn chưa nhập tên thực tập',
//                'id_specialized.required' => 'Bạn chưa chọn khoa',
//                'id_specialized.exists' => 'Không tồn tại khoa đã chọn'
            ]
        );
        $data = Internship_Type::create($request->all());
        return response()->json($data, 201);
    }

    public function edit($id, Request $request)
    {
        $this->validate(
            $request, [
            'name' => 'required',
//            'id_specialized' => 'required|exists:specialized,id'
        ], [
                'name.required' => 'Bạn chưa nhập tên thực tập',
//                'id_specialized.required' => 'Bạn chưa chọn khoa',
//                'id_specialized.exists' => 'Không tồn tại khoa đã chọn'
            ]
        );
        $data = Internship_Type::where('id', $id);
        if ($data->count() == 0)
            return response('Edit Failed', 400);
        $data->update($request->all());
        return response()->json($data->get(), 200);
    }

    public function destroy($id)
    {
        $data = Internship_Type::where('id', $id);
        if ($data->count() == 0)
            return response('Delete Failed', 400);
        $data->delete();
        return response('Delete Successfully', 200);
    }

}
