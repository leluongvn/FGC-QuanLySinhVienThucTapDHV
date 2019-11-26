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
        $this->validate($request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'content' => 'required'
            ], [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Mời nhập mã loại thực tập',
                'id_internship_type.exists' => 'Bộ môn thực tập không tồn tại',
                'content.required' => 'Bạn chưa nhập nội dung đề tài'
            ]
        );

        Topic::create($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'id_internship_type' => 'required|exists:internship_type,id',
                'content' => 'required',
            ], [
                'name.required' => 'Bạn chưa nhập tên đề tài',
                'id_internship_type.required' => 'Bạn chưa chọn loại thực tập',
                'id_internship_type.exists' => 'Loại thực tập không có',
                'content.required' => 'Bạn chưa nhập nội dung đề tài'
            ]
        );

        $Topic = Topic::find($id);
        $Topic->update($request->all());
        return 1;
    }

    public function destroy($id)
    {
        Topic::find($id)->delete();
        return 1;
    }

}
