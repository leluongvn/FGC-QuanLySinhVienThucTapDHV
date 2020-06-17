<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Type;

class Internship_TypeController extends Controller
{

    public function status($id)
    {
        $sub = Internship_Type::find($id);
        $sub->update(['status' => $sub->status == 1 ? 0 : 1]);
        return 1;
    }

    public function show()
    {
        return response()->json(Internship_Type::all());
    }

    public function showOne($id)
    {
        return response()->json(Internship_Type::find($id));
    }

    public function create(Request $request)
    {
        $this->validate(
            $request, [
            'name' => 'required'
        ], [
                'name.required' => 'Bạn chưa nhập tên thực tập'
            ]
        );

        Internship_Type::create($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {
        $this->validate(
            $request, [
            'name' => 'required'
        ], [
                'name.required' => 'Bạn chưa nhập tên thực tập'
            ]
        );

        Internship_Type::find($id)->update($request->all());
        return 1;
    }

    public function destroy($id)
    {
        $data = Internship_Type::find($id);
        if (sizeof($data->topic) <= 0 && sizeof($data->internship_time) <= 0) {
            $data->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }

    }

}
