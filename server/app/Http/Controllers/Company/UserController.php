<?php

namespace App\Http\Controllers\Company;

use App\Model\Company;
use App\Model\Internship_Topic;
use App\Model\Student;
use App\Model\User;
use App\Model\View_Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function status($id)
    {
        $user = User::find(Company::find($id)->id_user);
        $user->update([
            'status' => $user->status == 0 ? 1 : 0
        ]);
        return 1;
    }

    public function getDetail($id, $time)
    {
        $data = View_Profile::with('point')->where('company_id', $id)->where('id_internship_time', $time)->get();

        foreach ($data as $val) {
            $val['topic'] = is_null($val['point']) ? '' : Internship_Topic::with('topic')->find($val['point']->id_internship_topic)->topic->name;
            $val['point'] = is_null($val['point']) ? '' : $val['point'];
            $val['student'] = Student::with('user')->find($val->reg->id_student);
        }
        return response()->json($data);
    }

    public function getUser()
    {
        // return Auth::user()->id;
        $data = DB::table('users as u')
            ->select('t.id', 't.id_user', 'u.name', 't.address', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
            ->join('companies as t', 't.id_user', 'u.id')
            ->where('u.id', Auth::user()->id)
            ->first();
        return response()->json($data);
    }

    public function show()
    {
        $data = DB::table('users as u')
            ->select('c.id', 'c.id_user', 'c.boss', 'c.address', 'u.name', 'u.email', 'u.phone', 'c.fields', 'c.introduce', 'u.status')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->get();

        return $data;
    }

    public function showOne($id)
    {
        $data = DB::table('users as u')
            ->select('c.id', 'c.boss', 'c.id_user', 'c.address', 'u.name', 'u.email', 'u.phone', 'c.fields', 'c.introduce', 'u.status')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->where('c.id', $id)
            ->get();

        return $data;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'boss' => 'required',
            'email' => 'required|email|unique:users',
        ],
            [
                'name.required' => 'M???i nh???p t??n doanh nghi???p',
                'email.required' => 'M???i nh???p email',
                'email.email' => 'Email kh??ng t???n t???i',
                'email.unique' => 'Email n??y ???? t???n t???i',
                'phone.required' => 'M???i nh???p s??? ??i???n tho???i',
                'boss.required' => 'M???i nh???p t??n gi??m ?????c',
            ]
        );

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = app('hash')->make('123456');
            $user->phone = $request->phone;
            $user->id_role = 5;
            $user->note = $request->note;

            $user->save();

            $company = new Company();
            $company->id_user = $user->id;
            $company->fields = $request->fields;
            $company->introduce = $request->introduce;
            $company->address = $request->address;
            $company->boss = $request->boss;

            $company->save();

            return 1;
        } catch (\Exception $e) {
            return 0;
        }

    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'boss' => 'required',
            'email' => 'required|email',
        ], [
                'name.required' => 'M???i nh???p t??n doanh nghi???p',
                'email.required' => 'M???i nh???p email',
                'email.email' => 'Email kh??ng t???n t???i',
                'phone.required' => 'M???i nh???p s??? ??i???n tho???i',
                'boss.required' => 'M???i nh???p t??n gi??m ?????c',
            ]
        );
        try {
            $company = Company::find($id);
            $company->update($request->only('fields', 'id_user', 'introduce', 'address', 'boss'));

            $user = User::find($request->id_user);
            $user->update($request->only('name', 'email', 'phone', 'status'));

            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delete($id)
    {
        $user = Company::find($id);
        if (sizeof($user->internship) <= 0) {
            $user->delete();
            $user->user()->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }
    }
}
