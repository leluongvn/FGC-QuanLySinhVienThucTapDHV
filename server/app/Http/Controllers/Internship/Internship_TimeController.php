<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Internship_TimeController extends Controller
{

    public function show($id)
    {

        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $id)
            ->get();
        return response()->json($data);
    }

    public function getTime()
    {
//        Lấy danh sách học phần thực tập của sinh viên đã và đang học
        $data = DB::select('SELECT it.id,sr.id as id_student_reg,itype.name,
        DATE_FORMAT(it.start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(it.end_time, "%d/%m/%Y") as end_time
        FROM students s 
        JOIN users u ON u.id = s.id_user
        JOIN student_reg sr ON sr.id_student = s.id 
        JOIN internship_time it ON it.id = sr.id_internship_time 
        JOIN internship_type itype ON itype.id = it.id_internship_type
        WHERE u.id = ?
        ORDER BY it.start_time DESC', [Auth::user()->id]);

        return $data;
    }

    public function showOne($id)
    {
        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,start_time,end_time,start_topic,end_topic,start_company,end_company')
            ->where('id', $id)
            ->get();
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id_internship_type' => 'required|exists:internship_type,id',
                'course' => 'required',
                'start_time' => 'required',
                'end_time' => 'required'
            ],
            [
                'course.required' => 'Mời nhập khóa học',
                'start_time.required' => 'Nhập thời gian bắt đầu TT',
                'end_time.required' => 'Nhập thời gian kết thúc TT'
            ]
        );

        Internship_Time::insert($request->all());

        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $request->id_internship_type)
            ->get();
        return response()->json($data);
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'id_internship_type' => 'required|exists:internship_type,id',
                'course' => 'required',
                'start_time' => 'required',
                'end_time' => 'required'
            ],
            [
                'course.required' => 'Mời nhập khóa học',
                'start_time.required' => 'Nhập thời gian bắt đầu TT',
                'end_time.required' => 'Nhập thời gian kết thúc TT'
            ]
        );

        $edit = Internship_Time::find($id);
        $edit->update($request->all());

        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $request->id_internship_type)
            ->get();
        return response()->json($data);
    }

    public function destroy($type, $time)
    {
        Internship_Time::find($time)->delete();
        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $type)
            ->get();
        return response()->json($data);
    }

}
