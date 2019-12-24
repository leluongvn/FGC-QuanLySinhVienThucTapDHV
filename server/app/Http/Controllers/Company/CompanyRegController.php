<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Company_Reg;
use App\Model\Internship_Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyRegController extends Controller
{
    public function getAll($id)
    {
        $data = DB::select('SELECT ic.id,u.name,c.address,c.fields,ic.limit,ic.reg,ic.targets FROM users u
        JOIN companies c ON c.id_user = u.id
        JOIN internship_company ic ON ic.id_company = c.id
        WHERE ic.id_internship_time = ?', [$id]);

        return $data;
    }

    public function getReg($id)
    {
        $data = DB::select('SELECT cr.id,u.name,c.address,c.fields,ic.limit,ic.reg,ic.targets 
        FROM users u JOIN companies c ON c.id_user = u.id 
        JOIN internship_company ic ON ic.id_company = c.id 
        JOIN company_reg cr ON cr.id_internship_company = ic.id 
        WHERE cr.id_student_reg = ?', [$id]);

        return $data;
    }

    public function create(Request $request)
    {
        $tg = Internship_Company::find($request->id_internship_company);
        if ($tg->reg >= $tg->limit) {
            return 0;
        } else {
            $companyreg = new Company_Reg();
            $companyreg->fill($request->all());
            $companyreg->save();

            $internship = Internship_Company::find($request->id_internship_company);

            $internship->reg = $internship->reg + 1;
            $internship->save();

            return 1;
        }

    }

    public function update($id, Request $request)
    {
        $companyreg = Company_Reg::findOrFail($id);
        $companyreg->update($request->all());

        return 1;
    }

    public function delete($id)
    {
        $companyreg = Company_Reg::find($id);
        $companyreg->delete();

        $internship = Internship_Company::find($companyreg->id_internship_company);
        if ($internship->reg > 0) {
            $internship->reg = $internship->reg - 1;
            $internship->save();
        }

        return 1;
    }
}