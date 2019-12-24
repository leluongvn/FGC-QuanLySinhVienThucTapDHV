<?php

namespace App\Http\Controllers\Topic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Topic;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{

    public function show($type)
    {
        $data = DB::table('topics as t')
            ->select('t.id', 't.name', 't.file', 't.note', 't.status')
            ->join('internship_type as i', 'i.id', 't.id_internship_type')
            ->where('i.id', $type)
            ->get();
        return $data;
    }

    public function showOne($id)
    {
        return response()->json(Topic::find($id));
    }

    public function download($id)
    {
        $file = Topic::find($id);
        $path = 'upload/' . $file->file;
        return response()->download($path);
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'note' => 'required'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Mời nhập mã loại thực tập',
                'id_internship_type.exists' => 'Bộ môn thực tập không tồn tại',
                'note.required' => 'Bạn chưa nhập phần mô tả cho đề tài'
            ]
        );

        $data = new Topic;
        $data->name = $request->name;
        $data->id_internship_type = $request->id_internship_type;
        $data->note = $request->note;

        $data->save();

        return $data;
    }

    public function status($id, Request $request)
    {
        $tus = Topic::find($id);
        if ($request->status == 1) {
            $tus->status = 0;
            $tus->save();
            return $tus->status;
        } else if ($request->status == 0) {
            $tus->status = 1;
            $tus->save();
            return $tus->status;
        }
    }

    public function file($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'file' => 'mimes:zip,rar'
            ],
            [
                'file.mimes' => 'Chỉ cho phép tệp nén zip/rar'
            ]
        );
        if ($request->file != '') {
            $data = Topic::find($id);
            //file đính kèm
            $file = $request->file;
            $newName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $file->hashName();
            $file->move('upload', $newName);
            $data->file = $newName;

            $data->save();
        }

        return 1;
    }

    public function edit($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'note' => 'required'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Mời nhập mã loại thực tập',
                'id_internship_type.exists' => 'Bộ môn thực tập không tồn tại',
                'note.required' => 'Bạn chưa nhập phần mô tả cho đề tài'
            ]
        );

        $data = Topic::find($id);
        $data->name = $request->name;
        $data->id_internship_type = $request->id_internship_type;
        $data->note = $request->note;

        $data->save();
        return $id;
    }

    public function destroy($id)
    {
        Topic::find($id)->delete();
        return 1;
    }
}
