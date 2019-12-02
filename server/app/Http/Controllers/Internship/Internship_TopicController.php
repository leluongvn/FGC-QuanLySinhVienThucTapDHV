<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Topic;
use Illuminate\Support\Facades\DB;

class Internship_TopicController extends Controller
{

    public function show($id)
    {
        $data = DB::table('users as u')
            ->select('it.id','t.name','t.content','it.status')
            ->join('internship_topic as it','it.id_user','u.id')
            ->join('topics as t','t.id','it.id_topic')
            ->where('it.id_internship_time',$id)
            ->get();
        return $data;
    }

    public function getTopic($id)
    {
        $data = DB::select('select t.id,t.name from topics t join internship_type itype on itype.id=t.id_internship_type
        join internship_time itime on itime.id_internship_type = itype.id
        where itime.id = ? and t.id not in (select itopic.id_topic from internship_topic itopic
        where itopic.id_internship_time = ?)',[$id,$id]);
        return $data;
    }
    public function showOne($id)
    {
        
    }

    public function create(Request $request)
    {
        Internship_Topic::insert($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {
        
    }

    public function destroy($id)
    {
        Internship_Topic::find($id)->delete();
        return 1;
    }

}
