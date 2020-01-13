<?php

namespace App\Http\Controllers\Topic;

use Illuminate\Http\Request;
use App\Model\View_Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegController extends Controller
{

    public function getListReg($reg, $time)
    {
        $tg = View_Profile::where('id', $reg)->first();
        $data = DB::select('SELECT t.id, it.id as topic_id, t.name, t.file, t.note 
            FROM topics t 
            JOIN internship_topic it ON it.id_topic = t.id
            WHERE it.id_internship_time = ? AND (it.id_user = ? or it.id_user = ? or it.id_user = ?)', [$time, $tg->teacher_id,$tg->company_id, 1]
        );

        return $data;
    }

    public function getReg($reg)
    {
        $data = DB::select('SELECT t.id, it.id as topic_id,ip.id as reg_id, t.name, t.file, t.note 
            FROM topics t 
            JOIN internship_topic it ON it.id_topic = t.id
            JOIN internship_point ip ON ip.id_internship_topic = it.id
            WHERE ip.id_student_reg = ?', [$reg]);

        return $data;
    }

    public function showOne($id)
    {

    }

    public function download($id)
    {

    }

    public function create(Request $request)
    {

    }

    public function status($id, Request $request)
    {

    }

    public function file($id, Request $request)
    {

    }

    public function edit($id, Request $request)
    {

    }

    public function destroy($id)
    {

    }
}
