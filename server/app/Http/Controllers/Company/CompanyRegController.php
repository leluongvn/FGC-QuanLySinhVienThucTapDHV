<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Company;
use App\Model\CompanyReg;
use App\Model\Internship_Time;
use Illuminate\Support\Facades\DB;
class CompanyRegController extends Controller
{
    /* 
        hàm để lấy ra dữ liệu trong bảng company và internship_time
    */
    public function getCompanyInternshipTime()
    {
        $companys = Company::all();
        $shiptimes  = Internship_Time::all();

        foreach ($companys as $company) {
            $cm[] = $company;
        }
        foreach ($shiptimes as $shiptime) {
            $st[] = $shiptime;
        }
        $result = array_merge($cm, $st);
        return $result;
    }
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'limit'            =>     'required',
                'registration'     =>     'required',

            ],
            [
                'limit.required'            => 'Bạn chưa nhập giới hạn người đăng kí',
                'registration.required'     => 'Bạn chưa nhập số người đăng kí',
            ]
        );
        CompanyReg::create($request->all());
        $result = new CompanyRegController();
        $results = $result->getCompanyInternshipTime();

        return response()->json($results, 201);
    }
    public function update($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'limit'            =>     'required',
                'registration'     =>     'required',

            ],
            [
                'limit.required'            => 'Bạn chưa nhập giới hạn người đăng kí',
                'registration.required'     => 'Bạn chưa nhập số người đăng kí',
            ]
        );
        $companyreg = CompanyReg::findOrFail($id);
        $companyreg->update($request->all());
        $result = new CompanyRegController();
        $results = $result->getCompanyInternshipTime();

        return response()->json($results, 200);
    }

    public function showOne($id,$type)
    {
            $data = DB::table('company_reg')
            ->select('*')
            ->where('id_internship_time', $id)
            ->where('id',$type)
            ->get();
        return response()->json($data);
    }
    public function show($id)
    {
         $data = DB::table('company_reg')
            ->selectRaw('*')
            ->where('id_internship_time', $id)
            ->get();
         return response()->json($data);
    }
    public function delete($id)
    {
        CompanyReg::findOrFail($id)->delete();
        return response('Xóa thành công', 200);
    }
    /* 
        http://localhost:8000/companyreg/search/company/reg?tukhoa=(id) => để tìm kiếm theo id
    */
    public function search(Request $request)
    {
        $companyreg = CompanyReg::where('id', 'like', '%' . $request->tukhoa . '%')->get();
        return response($companyreg, 200);
    }
}
