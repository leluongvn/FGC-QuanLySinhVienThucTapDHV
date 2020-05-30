<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Internship_TimeController extends Controller
{

    public function all()
    {
        $data = Internship_Time::with('internship_type')->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,year,semester,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $id)
            ->paginate(9);
        return response()->json($data);
    }

    public function search($id, $temp)
    {
        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,year,semester,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $id)
            ->where('course', 'like', '%' . $temp . '%')
            ->paginate(9);
        return response()->json($data);
    }

    public function getTime()
    {
//        Lấy danh sách học phần thực tập của sinh viên đã và đang học
        $data = DB::select('SELECT it.id,sr.id as id_student_reg,itype.name,it.course,it.semester, it.year,
                it.start_time,it.end_time,it.start_company,it.end_company, it.start_topic, it.end_topic
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
            ->selectRaw('id,id_internship_type,year,semester,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time,start_topic,end_topic,start_company,end_company')
            ->where('id', $id)
            ->first();
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id_internship_type' => 'required|exists:internship_type,id',
                'course' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'start_topic' => 'after:start_time|before:end_time',
                'end_topic' => 'after:start_topic|before:end_time',
                'start_company' => 'after:start_time|before:end_time',
                'end_company' => 'after:start_topic|before:end_time'
            ],
            [
                'course.required' => 'Mời nhập khóa học',
                'start_time.required' => 'Nhập thời gian bắt đầu TT',
                'end_time.required' => 'Nhập thời gian kết thúc TT',
                'end_time.after' => 'Thời gian thực tập không hợp lệ',
                'start_topic.after' => 'Thời gian đăng ký đề tài không hợp lệ',
                'start_topic.before' => 'Thời gian đăng ký đề tài không hợp lệ',
                'end_topic.after' => 'Thời gian đăng ký đề tài không hợp lệ',
                'end_topic.before' => 'Thời gian đăng ký đề tài không hợp lệ',
                'start_company.after' => 'Thời gian đăng ký đề tài không hợp lệ',
                'start_company.before' => 'Thời gian đăng ký đề tài không hợp lệ',
                'end_company.after' => 'Thời gian đăng ký đề tài không hợp lệ',
                'end_company.before' => 'Thời gian đăng ký đề tài không hợp lệ',
            ]
        );

        Internship_Time::insert($request->all());

        return 1;
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'id_internship_type' => 'required|exists:internship_type,id',
                'course' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time'
            ],
            [
                'course.required' => 'Mời nhập khóa học',
                'start_time.required' => 'Nhập thời gian bắt đầu TT',
                'end_time.required' => 'Nhập thời gian kết thúc TT',
                'end_time.after' => 'Thời gian kết thúc phải lớn hơn ngày bắt đầu'
            ]
        );

        $edit = Internship_Time::find($id);
        $edit->update($request->all());

        return 1;
    }

    public function destroy($type, $time)
    {
        Internship_Time::find($time)->delete();
        return 1;
    }

}
