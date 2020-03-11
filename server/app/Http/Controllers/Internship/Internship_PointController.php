<?php

namespace App\Http\Controllers\Internship;

use App\Model\View_Profile;
use App\Model\Role;
use App\Model\Internship_Point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Internship_PointController extends Controller
{
    public function show($id)
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Admin" || $role->name === "Trợ lý đào tạo") {
            $data = DB::select('SELECT ip.product,ip.id,s.mssv,u.name,t.name as topic_name,v.teacher_name,v.company_name,ip.teacher_point,ip.company_comment,ip.company_point,ip.total_point 
            FROM users u 
            JOIN students s ON s.id_user = u.id 
            JOIN student_reg sr ON sr.id_student = s.id 
            LEFT JOIN view_profile v ON v.id = sr.id 
            LEFT JOIN internship_point ip on ip.id_student_reg = sr.id
            LEFT JOIN internship_topic it ON it.id = ip.id_internship_topic
            LEFT JOIN topics t ON t.id = it.id_topic
            WHERE sr.id_internship_time = ?', [$id]);
        }
        else if($role->name === "Giảng viên" || $role->name === "Trưởng bộ môn"){
            $data = DB::select('SELECT ip.product,ip.id,s.mssv,u.name,t.name as topic_name,v.teacher_name,v.company_name,ip.teacher_point,ip.company_comment,ip.company_point,ip.total_point 
            FROM users u 
            JOIN students s ON s.id_user = u.id 
            JOIN student_reg sr ON sr.id_student = s.id 
            LEFT JOIN view_profile v ON v.id = sr.id 
            LEFT JOIN internship_point ip on ip.id_student_reg = sr.id
            LEFT JOIN internship_topic it ON it.id = ip.id_internship_topic
            LEFT JOIN topics t ON t.id = it.id_topic
            WHERE sr.id_internship_time = ? and v.teacher_id = ?', [$id,Auth::user()->id]);
        }else if($role->name === "Doanh nghiệp"){
            $data = DB::select('SELECT ip.product,ip.id,s.mssv,u.name,t.name as topic_name,v.teacher_name,v.company_name,ip.teacher_point,ip.company_comment,ip.company_point,ip.total_point 
            FROM users u 
            JOIN students s ON s.id_user = u.id 
            JOIN student_reg sr ON sr.id_student = s.id 
            LEFT JOIN view_profile v ON v.id = sr.id 
            LEFT JOIN internship_point ip on ip.id_student_reg = sr.id
            LEFT JOIN internship_topic it ON it.id = ip.id_internship_topic
            LEFT JOIN topics t ON t.id = it.id_topic
            WHERE sr.id_internship_time = ? and v.company_id = ?', [$id,Auth::user()->id]);
        }else if($role->name === "Sinh viên"){
            $data = DB::select('SELECT ip.product,ip.id,s.mssv,u.name, itype.name as name_type,DATE_FORMAT(itime.start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(itime.end_time, "%d/%m/%Y") as end_time,t.name as topic_name,v.teacher_name,v.company_name,ip.teacher_point,ip.company_comment,ip.company_point,ip.total_point 
            FROM users u 
            JOIN students s ON s.id_user = u.id 
            JOIN student_reg sr ON sr.id_student = s.id
            JOIN internship_time itime ON itime.id = sr.id_internship_time
            JOIN internship_type itype ON itype.id = itime.id_internship_type
            LEFT JOIN view_profile v ON v.id = sr.id 
            LEFT JOIN internship_point ip on ip.id_student_reg = sr.id
            LEFT JOIN internship_topic it ON it.id = ip.id_internship_topic
            LEFT JOIN topics t ON t.id = it.id_topic
            WHERE u.id = ?', [Auth::user()->id]);
        }
        return $data;
    }

    public function create(Request $request)
    {
        $Internship_Point = Internship_Point::create($request->all());
        return response()->json($Internship_Point, 201);
    }

    public function update($id, Request $request)
    {
        $Internship_Point = Internship_Point::find($id)->update($request->all());
        return response()->json($Internship_Point, 201);
    }

    public function showOne($id)
    {
        return Internship_Point::find($id);
    }

    public function delete($id)
    {
        Internship_Point::find($id)->delete();
        return 1;
    }

}
