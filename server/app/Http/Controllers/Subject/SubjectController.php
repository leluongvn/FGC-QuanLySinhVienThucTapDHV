<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Model\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function show()
    {
        return response()->json(Subject::all());
    }

    public function showOne($id)
    {
        return response()->json(Subject::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id' => 'required',
                // 'id_internship_time' => 'required|exists:internship_time,id',
                'id_specialized' => 'required',
                'name' => 'required',
                'note' => 'required',
                
            ], [
                'id.required' => 'Bạn chưa ghi id',
                'id_specialized.required' => 'Bạn chưa chọn loại chuc vu',
                'name.required' => 'Bạn chưa ghi ten',
                'note.required' => 'Bạn chưa ghi chu',
                // 'id_internship_time.exists' => 'Thời gian thực tập không tồn tại',
            
            ]
        );

        $Subject = Subject::create($request->all());
        return response()->json($Subject, 201);
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'id' => 'required',
                // 'id_internship_time' => 'required|exists:internship_time,id',
                'id_specialized' => 'required',
                'name' => 'required',
                'note' => 'required',
            ], [
                'id.required' => 'Bạn chưa ghi id',
                'id_specialized.required' => 'Bạn chưa chọn loại chuc vu',
                'name.required' => 'Bạn chưa ghi ten',
                'note.required' => 'Bạn chưa ghi chu',
            ]
        );

        $Subject = Subject::find($id);
        if ($Subject->count() == 0)
            return response('Edit Failed', 200);
        $Subject->update($request->all());
        return response()->json($Subject->get(), 200);
    }

    public function destroy($id)
    {
        $Subject = Subject::find($id);
        if ($Subject->count() == 0)
            return response('Delete Failed', 200);
        $Subject->delete();
        return response('Delete Successfully', 200);
    }

}
