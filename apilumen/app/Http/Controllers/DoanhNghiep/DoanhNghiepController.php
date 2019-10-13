<?php

namespace App\Http\Controllers\DoanhNghiep;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Doanhnghiep;

class DoanhNghiepController extends Controller
{

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'        =>     'required|unique:enterprise,name',
                'phone'       =>     'required',
                'address'     =>     'required',
                'email'       =>     'required',
                'introduce'   =>     'required',
            ],
            [
                'name.required'      => 'Bạn chưa nhập tên doanh nghiệp',
                'name.unique'        => 'Doanh nghiệp đã tồn tại',
                'phone.required'     => 'Bạn chưa nhập sdt',
                'address.required'   => 'Bạn chưa nhập địa chỉ',
                'email.required'     => 'Bạn chưa nhập email',
                'introduce.required' => 'Bạn chưa nhập giới thiệu công ty',
            ]
        );
        $doanhnghiep = Doanhnghiep::create($request->all());

        return response()->json($doanhnghiep, 201);
    }
    public function update($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'name'        =>     'required',
                'phone'       =>     'required',
                'address'     =>     'required',
                'email'       =>     'required',
                'introduce'   =>     'required',
            ],
            [
                'name.required'      => 'Bạn chưa nhập tên doanh nghiệp',
                'phone.required'     => 'Bạn chưa nhập sdt',
                'address.required'   => 'Bạn chưa nhập địa chỉ',
                'email.required'     => 'Bạn chưa nhập email',
                'introduce.required' => 'Bạn chưa nhập giới thiệu công ty',
            ]
        );
        $doanhnghiep = Doanhnghiep::findOrFail($id);
        $doanhnghiep->update($request->all());

        return response()->json($doanhnghiep, 200);
    }
    public function delete($id)
    {
        Doanhnghiep::findOrFail($id)->delete();
        return response('Xóa thành công', 200);
    }
    public function show()
    {
        return response()->json(Doanhnghiep::all());
    }
    public function showOne($id)
    {
        return response()->json(Doanhnghiep::find($id));
    }
}
