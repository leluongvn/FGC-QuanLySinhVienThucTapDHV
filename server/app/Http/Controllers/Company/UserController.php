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
            ->select('c.id','c.boss', 'c.id_user', 'c.address', 'u.name', 'u.email', 'u.phone', 'c.fields', 'c.introduce', 'u.status')
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
                'name.required' => 'Mời nhập tên doanh nghiệp',
                'email.required' => 'Mời nhập email',
                'email.email' => 'Email không tồn tại',
                'email.unique' => 'Email này đã tồn tại',
                'phone.required' => 'Mời nhập số điện thoại',
                'boss.required' => 'Mời nhập tên giám đốc',
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
                'name.required' => 'Mời nhập tên doanh nghiệp',
                'email.required' => 'Mời nhập email',
                'email.email' => 'Email không tồn tại',
                'phone.required' => 'Mời nhập số điện thoại',
                'boss.required' => 'Mời nhập tên giám đốc',
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
        $company = Company::find($id);

        User::find($company->id_user)->delete();
        $company->delete();

        return 1;
    }
}
