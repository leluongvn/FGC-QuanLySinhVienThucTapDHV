<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Model\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function active()
    {
        $data = Subject::where('status', 1)->get();
        return response()->json($data);
    }

    public function status($id)
    {
        $sub = Subject::find($id);
        $sub->update(['status' => $sub->status == 1 ? 0 : 1]);
        return 1;
    }

    public function show()
    {
        $data = Subject::all();
        foreach ($data as $val) {
            $tg = Teacher::with('tbm')->where('id_subject', $val->id)->first();
            $val['user'] = isset($tg->tbm) ? $tg->tbm->name : '';
        }
        return response()->json($data);
    }

    public function showOne($id)
    {
        $data = Subject::with('teacher')->find($id);
        foreach ($data->teacher as $key => $val) {
            $val['user'] = Teacher::find($val->id)->user;
        }

        $data = Subject::find($id);

        return response()->json($data);
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:subjects',
            ], [
                'name.required' => 'Mời nhập tên bộ môn',
                'name.unique' => 'Bộn môn này đã có',
            ]
        );

        Subject::create($request->all());
        return 1;
    }

    public function update($id, Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
            ], [
                'name.required' => 'Mời nhập tên bộ môn',
            ]
        );

        try {
            Subject::find($id)->update($request->all());
            return 1;
        } catch (\Exception $e) {
            return response()->json()->with('error', 'Bộ môn này đã có');
        }
    }

    public function destroy($id)
    {
        $del = Subject::find($id);
        if (sizeof($del->teacher) <= 0) {
            $del->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }
    }

}
