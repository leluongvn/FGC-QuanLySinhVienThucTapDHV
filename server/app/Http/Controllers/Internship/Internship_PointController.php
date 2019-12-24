<?php

namespace App\Http\Controllers\Internship;

use App\Model\View_Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Internship_PointController extends Controller
{
    public function show($id)
    {
        $data = DB::select('SELECT s.id,s.mssv,u.name,t.name as topic_name,v.teacher_name,v.company_name,ip.teacher_point,ip.company_comment,ip.total_point 
        FROM users u 
        JOIN students s ON s.id_user = u.id 
        JOIN student_reg sr ON sr.id_student = s.id 
        LEFT JOIN view_profile v ON v.id = sr.id 
        LEFT JOIN internship_point ip on ip.id_student_reg = sr.id
        LEFT JOIN internship_topic it ON it.id = ip.id_internship_topic
        LEFT JOIN topics t ON t.id = it.id_topic
        WHERE sr.id_internship_time = ?', [$id]);

        return $data;
    }

    public function create(Request $request)
    {

    }

    public function update($id, Request $request)
    {

    }

    public function showOne($id)
    {

    }


    public function getCompany($id)
    {

    }

    public function delete($id)
    {

    }

}
