<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Company;

class CompanyController extends Controller
{

    public function create(Request $request)
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
        $Company = Company::create($request->all());

        return response()->json($Company, 201);
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
        $Company = Company::findOrFail($id);
        $Company->update($request->all());

        return response()->json($Company, 200);
    }
    public function delete($id)
    {
        Company::findOrFail($id)->delete();
        return response('Xóa thành công', 200);
    }
    public function show()
    {
        return response()->json(Company::all());
    }
    public function showOne($id)
    {
        return response()->json(Company::find($id));
    }
}
