<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use App\Model\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function show()
    {
        return response()->json(Position::all());
    }

    public function showOne($id)
    {
        return response()->json(Position::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id_teacher' => 'required',
                // 'id_internship_time' => 'required|exists:internship_time,id',
                'id_position_type' => 'required',
                'note' => 'required',
                
            ], [
                'note.required' => 'Bạn chưa ghi chu',
                'id_teacher.required' => 'Bạn chưa chọn giao vien',
                'id_position_type.required' => 'Bạn chưa chọn loại chuc vu',
                // 'id_internship_time.exists' => 'Thời gian thực tập không tồn tại',
            
            ]
        );

        $Position = Position::create($request->all());
        return response()->json($Position, 201);
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'id_teacher' => 'required',
                // 'id_internship_time' => 'required|exists:internship_time,id',
                'id_position_type' => 'required',
                'note' => 'required',
            ], [
                'note.required' => 'Bạn chưa ghi chu',
                'id_teacher.required' => 'Bạn chưa chọn giao vien',
                'id_position_type.required' => 'Bạn chưa chọn loại chuc vu',
            ]
        );

        $Position = Position::find($id);
        if ($Position->count() == 0)
            return response('Edit Failed', 200);
        $Position->update($request->all());
        return response()->json($Position->get(), 200);
    }

    public function destroy($id)
    {
        $Position = Position::find($id);
        if ($Position->count() == 0)
            return response('Delete Failed', 200);
        $Position->delete();
        return response('Delete Successfully', 200);
    }

}
