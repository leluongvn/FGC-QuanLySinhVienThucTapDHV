<?php

namespace App\Http\Controllers\SinhVien;

use App\Http\Controllers\Controller;
use App\Model\Sinhvien;
use Illuminate\Http\Request;

class SinhVienController extends Controller
{
    public function getAll()
    {
    
        return response()->json(Sinhvien::all());
    }
    public function getSingle($id)
    {
        return response()->json(Sinhvien::where('id_student', $id)->first());
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'id_student' => 'required|unique:sinhvien|max:20|min:11',
            'username'   => 'required',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ]);
        $Sinhvien = Sinhvien::create($request->all());
        return response()->json($Sinhvien, 201);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_student' => 'required|unique:sinhvien|max:20|min:11',
            'username'   => 'required',
            'password'   => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ]);
        $Sinhvien = Sinhvien::where('id_Sinhvien', $id)->first();
        $Sinhvien->update($request->all());
        return response()->json($Sinhvien, 200);
    }
    public function delete($id)
    {
        $Sinhvien = Sinhvien::where('id_Sinhvien', $id)->first();
        $Sinhvien->delete();
        return response('delete complete ', 200);
    }
}
