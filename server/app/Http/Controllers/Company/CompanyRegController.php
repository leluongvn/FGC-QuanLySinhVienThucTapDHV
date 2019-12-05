<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Company;
use App\Model\CompanyReg;
use App\Model\Internship_Company;
use App\Model\Internship_Time;
use Illuminate\Support\Facades\DB;

class CompanyRegController extends Controller
{

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'limit' => 'required'

            ],
            [
                'limit.required' => 'Thất bại, Mời nhập sĩ số của doanh nghiệp'
            ]
        );
        Internship_Company::create($request->all());

        return 1;
        // return response()->json($results, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate(
            $request,
            [
                'limit' => 'required'

            ],
            [
                'limit.required' => 'Thất bại, Mời nhập sĩ số của doanh nghiệp'
            ]
        );
        $company = Internship_Company::findOrFail($id);
        $company->id_company = $request->id_company;
        $company->limit = $request->limit;

        $company->update();
        return 1;
    }

    public function showOne($id)
    {
        $data = DB::table('users as u')
            ->select('ci.id', 'c.id as id_company', 'u.name', 'ci.limit')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->join('internship_company as ci', 'ci.id_company', 'c.id')
            ->where('ci.id', $id)
            ->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = DB::table('users as u')
            ->select('ci.id', 'u.name', 'u.phone', 'u.email', 'c.address', 'ci.limit', 'ci.reg')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->join('internship_company as ci', 'ci.id_company', 'c.id')
            ->where('ci.id_internship_time', $id)
            ->get();
        return response()->json($data);
    }

    // Lấy danh sách công ty chưa đăng ký trong kỳ thực tập $id
    public function getCompany($id)
    {
        $data = DB::select('select c.id,u.name from users u join companies c on c.id_user=u.id
            where c.id not in (select id_company from internship_company where id_internship_time = ?)', [$id]);
        return $data;
        $data = DB::table('users as u')
            ->select('c.id', 'u.name', 'ci.limit')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->join('internship_company as ci', 'ci.id_company', 'c.id')
            ->where('ci.id_internship_time', $id)
            ->get();
        return response()->json($data);
    }

    public function delete($id)
    {
        Internship_Company::findOrFail($id)->delete();
        return response('Xóa thành công', 200);
    }

    /*
        http://localhost:8000/companyreg/search/company/reg?tukhoa=(id) => để tìm kiếm theo id
    */
    public function search(Request $request)
    {
        $company = Internship_Company::where('id', 'like', '%' . $request->tukhoa . '%')->get();
        return response($company, 200);
    }
}
