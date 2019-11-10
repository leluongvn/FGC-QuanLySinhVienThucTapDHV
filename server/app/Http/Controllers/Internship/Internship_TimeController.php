<?php

namespace App\Http\Controllers\Internship;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Internship_Type;
use Illuminate\Support\Facades\DB;

class Internship_TimeController extends Controller
{

    public function show($id)
    {

        $data = DB::table('internship_time')
            ->selectRaw('id,id_internship_type,course,DATE_FORMAT(start_time, "%d/%m/%Y") as start_time,DATE_FORMAT(end_time, "%d/%m/%Y") as end_time')
            ->where('id_internship_type', $id)
            ->get();
        return response()->json($data);
    }

    public function showOne($id)
    {
        return response()->json(Internship_Type::find($id));
    }

    public function create(Request $request)
    {

    }

    public function edit($id, Request $request)
    {

    }

    public function destroy($id)
    {

    }

}
