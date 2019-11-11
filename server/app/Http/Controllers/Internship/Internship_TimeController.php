<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Type;
use App\Model\Internship_Time;
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

    public function showOne($id)
    {
        return response()->json(Internship_Time::find($id));
    }

    public function create(Request $request)
    {   
        $this->validate($request,
            [
                'course'    =>'required',
                'start_time'=>'required',
                'end_time'  => 'required'
            ],
            [
                'course.required'    =>'Mời nhập khóa học',
                'start_time.required'=>'Nhập thời gian bắt đầu TT',
                'end_time.required'  => 'Nhập thời gian kết thúc TT'
            ]
        );
        Internship_Time::insert($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {

    }

    public function destroy($id)
    {

    }

}
