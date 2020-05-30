<?php

namespace App\Http\Controllers\Internship;

use App\Model\Role;
use App\Model\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Internship_TopicController extends Controller
{

    public function show($id)
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Admin") {
            $data = DB::table('users as u')
                ->select('it.id', 'it.id_topic', 't.name', 'u.name as create_by', 't.note', 't.file')
                ->join('internship_topic as it', 'it.id_user', 'u.id')
                ->join('topics as t', 't.id', 'it.id_topic')
                ->where('it.id_internship_time', $id)
                ->get();
            return $data;
        } else if ($role->name !== "Sinh viên") {
            $data = DB::table('users as u')
                ->select('it.id', 'it.id_topic', 't.name', 'u.name as create_by', 't.note', 't.file')
                ->join('internship_topic as it', 'it.id_user', 'u.id')
                ->join('topics as t', 't.id', 'it.id_topic')
                ->where('it.id_internship_time', $id)
                ->where('it.id_user', Auth::user()->id)
                ->orWhere('u.name', 'Admin')
                ->get();
            return $data;
        }
    }

    public function getTopic($id)
    {
        $data = DB::select('select t.id,t.name from topics t 
        join internship_type itype on itype.id=t.id_internship_type
        join internship_time itime on itime.id_internship_type = itype.id
        where itime.id = ? and t.id not in (select itopic.id_topic from internship_topic itopic
        where itopic.id_internship_time = ?)', [$id, $id]);
        return $data;
    }

    public function create(Request $request)
    {
        foreach ($request->id_topic as $item) {
            $data = new Internship_Topic();
            $data->id_user = Auth::user()->id;
            $data->id_topic = $item;
            $data->id_internship_time = $request->id_internship_time;

            $data->save();
        }
        return 1;
        // Internship_Topic::insert($request->all());
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
