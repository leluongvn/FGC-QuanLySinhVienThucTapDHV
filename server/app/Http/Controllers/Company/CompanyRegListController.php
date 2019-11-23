<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CompanyRegList;

class CompanyRegListController extends Controller
{
    public function create(Request $request)
    {
        $CompanyRegList = CompanyRegList::create($request->all());

        return response()->json($CompanyRegList, 201);
    }

    public function update($id, Request $request)
    {
        $CompanyRegList = CompanyRegList::findOrFail($id);
        $CompanyRegList->update($request->all());

        return response()->json($CompanyRegList, 200);
    }

    public function show()
    {
        return response()->json(CompanyRegList::all());
    }

    public function showOne($id)
    {
        return response()->json(CompanyRegList::find($id));
    }

    public function delete($id)
    {
        CompanyRegList::findOrFail($id)->delete();
        return response('Xóa thành công', 200);
    }
    public function search(Request $request)

    {
        $companyreglist = CompanyRegList::where('id', 'like', '%' . $request->tukhoa2 . '%')->get();
        return response($companyreglist, 200);
    }
}
