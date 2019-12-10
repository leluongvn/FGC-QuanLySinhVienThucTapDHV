<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Company;
use App\Model\Company_Reg;
use App\Model\Internship_Company;
use App\Model\Internship_Time;
use Illuminate\Support\Facades\DB;

class CompanyRegInternController extends Controller
{
    public function create(Request $request){

        $companyreg = new Company_Reg();
        $companyreg->fill($request->all());
        $companyreg->save();

        $internship = Internship_Company::find($request->id_internship_company);

        $internship->reg = $internship->reg + 1 ;
        $internship->save();
        
        return response()->json($companyreg);
    }

    public function update($id, Request $request)
    {
        $companyreg = Company_Reg::findOrFail($id);
        $companyreg->update($request->all());

        return response()->json($companyreg);
    }

    public function delete($id, Request $request)
    {
        $companyreg = Company_Reg::find($id);
        $companyreg->delete();
        return response()->json('xóa thành công');
    }
}