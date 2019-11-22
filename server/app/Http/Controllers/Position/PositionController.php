<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use App\Model\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{

    public function show($subject,$id)
    {
        $data = DB::select('SELECT p.id,t.msgv,t.name as teacher,s.name as subject,t.email,pt.name as position
        FROM teachers t JOIN positions p on p.id_teacher = t.id
        JOIN position_type pt on pt.id = p.id_position_type
        JOIN subjects s on s.id = t.id_subject
        where id_internship_time = ? and s.id = ?',[$id, $subject]);   
        return $data;
    }

    public function getCreate($subject, $id){
        $data = DB::select('SELECT * FROM teachers 
        where id_subject = ? and id not in (SELECT id_teacher 
        FROM positions where id_internship_time = ?)',[$subject, $id]);   
        return $data;
    }
    public function showOne($id)
    {
        return response()->json(Position::find($id));
    }

    public function create(Request $request)
    {
        // $this->validate($request,
        //     [
        //         'id_teacher' => 'required',
        //         // 'id_internship_time' => 'required|exists:internship_time,id',
        //         'id_position_type' => 'required',
        //         'note' => 'required',
                
        //     ], [
        //         'note.required' => 'Bạn chưa ghi chu',
        //         'id_teacher.required' => 'Bạn chưa chọn giao vien',
        //         'id_position_type.required' => 'Bạn chưa chọn loại chuc vu',
        //         // 'id_internship_time.exists' => 'Thời gian thực tập không tồn tại',
            
        //     ]
        // );
        
        
        Position::create($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {
        // $this->validate($request,
        //     [
        //         'id_teacher' => 'required',
        //         // 'id_internship_time' => 'required|exists:internship_time,id',
        //         'id_position_type' => 'required',
        //         'note' => 'required',
        //     ], [
        //         'note.required' => 'Bạn chưa ghi chu',
        //         'id_teacher.required' => 'Bạn chưa chọn giao vien',
        //         'id_position_type.required' => 'Bạn chưa chọn loại chuc vu',
        //     ]
        // );

        $Position = Position::find($id);
        $Position->update($request->all());
        return response('Update Successfully', 200);
    }

    public function destroy($id)
    {
        $Position = Position::find($id)->delete();
        return response('Delete Successfully', 200);
    }

}
