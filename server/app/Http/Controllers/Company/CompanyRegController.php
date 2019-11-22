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
                // 'registration'     =>     'required',

            ],
            [
                'limit.required'            => 'Bạn chưa nhập giới hạn người đăng kí',
                // 'registration.required'     => 'Bạn chưa nhập số người đăng kí',
            ]
        );
        CompanyReg::create($request->all());
        $result = new CompanyRegController();
        // $results = $result->getCompanyInternshipTime();
        return 1;
        return response()->json($results, 201);
    }
    public function update($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'limit'            =>     'required',
                // 'registration'     =>     'required',

            ],
            [
                'limit.required'            => 'Bạn chưa nhập giới hạn người đăng kí',
                // 'registration.required'     => 'Bạn chưa nhập số người đăng kí',
            ]
        );
        $companyreg = CompanyReg::findOrFail($id);
        $companyreg->id_company = $request->id_company;
        $companyreg->limit = $request->limit;
        
        $companyreg->update();

        // $result = new CompanyRegController();
        // $results = $result->getCompanyInternshipTime();
        return 1;
        // return response()->json($results, 200);
    }

    public function showOne($id)
    {
        $data = DB::select('SELECT cr.id,c.id as id_company,c.name,c.phone,c.email,c.address,cr.limit,cr.registration 
        from companies c join company_reg cr on c.id = cr.id_company 
        WHERE cr.id = ?',[$id]); 
         return response()->json($data);
    }
    public function show($id)
    {
        $data = DB::select('SELECT cr.id,c.name,c.phone,c.email,c.address,cr.limit,cr.registration 
        from companies c join company_reg cr on c.id = cr.id_company 
        WHERE cr.id_internship_time = ?',[$id]); 
         return response()->json($data);
    }
    // Lấy danh sách công ty chưa đăng ký trong kỳ thực tập $id
    public function getCompany($id){
        $data = DB::select('SELECT * from companies 
        WHERE id not in (SELECT id_company from company_reg WHERE id_internship_time = ?)',[$id]); 
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
