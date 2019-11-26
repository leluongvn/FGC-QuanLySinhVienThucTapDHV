<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Model\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function show()
    {
        return response()->json(Subject::all());
    }

    public function showOne($id)
    {
        return response()->json(Subject::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request,
            [
                'id' => 'required',
                'name' => 'required',
                'note' => 'required',

            ], [
                'id.required' => 'Bạn chưa ghi id',
                'name.required' => 'Bạn chưa ghi ten',
                'note.required' => 'Bạn chưa ghi chu'
            ]
        );

        Subject::create($request->all());
        return 1;
    }

    public function edit($id, Request $request)
    {
        $this->validate($request,
            [
                'id' => 'required',
                'name' => 'required',
                'note' => 'required',
            ], [
                'id.required' => 'Bạn chưa ghi id',
                'name.required' => 'Bạn chưa ghi ten',
                'note.required' => 'Bạn chưa ghi chu',
            ]
        );

        $Subject = Subject::find($id);
        $Subject->update($request->all());
        return 1;
    }

    public function destroy($id)
    {
        Subject::find($id)->delete();
        return 1;
    }

}
