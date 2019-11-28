<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Type;

class Internship_TypeController extends Controller
{

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
        Internship_Type::where('id', $id)->delete();
        return 1;
    }

}
