<?php

namespace App\Http\Controllers\Topic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Topic;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{

    public function show($type)
    {
        $data = DB::table('topics as t')
            ->select('t.id', 't.name', 't.content', 't.status')
            ->join('internship_type as i', 'i.id', 't.id_internship_type')
            ->where('i.id', $type)
            ->get();
        return $data;
    }

    public function showOne($id)
    {
        return response()->json(Topic::find($id));
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'content' => 'required|mimes:zip,rar'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Mời nhập mã loại thực tập',
                'id_internship_type.exists' => 'Bộ môn thực tập không tồn tại',
                'content.required' => 'Bạn chưa chọn file cho đề tài',
                'content.mimes' => 'Chỉ cho phép tệp nén zip,rar' 
            ]
        );
        $data = new Topic;
        $data->name = $request->name;
        $data->id_internship_type = $request->id_internship_type;
        $file = $request->content;
        $newName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $file->hashName();
        $file->move('upload', $newName);
        $data->content = $newName;
        $data->save();
        return 1;
    }
    public function edit($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'content' => 'required|mimes:zip,rar'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Bạn chưa chọn loại thực tập',
                'id_internship_type.exists' => 'Loại thực tập không có',
                'content.required' => 'Bạn chưa chọn file cho đề tài',
                'content.mimes' => 'Chỉ cho phép tệp nén zip,rar' 
            ]
        );

        $data = Topic::find($id);
        $data->name = $request->name;
        $data->id_internship_type = $request->id_internship_type;
        $path='upload/'.$data->content;
        unlink(env('PUBLIC_PATH', base_path('public')) . ($path ? '/' . $path : $path));
        $file = $request->content;
        $newName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $file->hashName();
        $file->move('upload', $newName);
        $data->content = $newName;
        $data->save();
        return 1;
    }

    public function destroy($id)
    {
        Topic::find($id)->delete();
        return 1;
    }
}
