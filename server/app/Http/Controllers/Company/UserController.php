<?php

namespace App\Http\Controllers\Company;

use App\Model\Company;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function show()
    {
        $data = DB::table('users as u')
            ->select('c.id', 'c.id_user', 'c.address', 'u.name', 'u.email', 'u.phone', 'c.fields', 'c.introduce', 'u.status')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->get();

        return $data;
    }

    public function showOne($id)
    {
        $data = DB::table('users as u')
            ->select('c.id', 'c.id_user', 'c.address', 'u.password', 'u.name', 'u.email', 'u.phone', 'c.fields', 'c.introduce', 'u.status')
            ->join('companies as c', 'c.id_user', 'u.id')
            ->where('c.id', $id)
            ->get();

        return $data;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ],
            [
                'name.required' => 'Mời nhập tên doanh nghiệp',
                'email.required' => 'Mời nhập email',
                'email.email' => 'Email không tồn tại',
                'email.unique' => 'Email này đã tồn tại',
                'passwrod.required' => 'Mời nhập mật khẩu',
            ]);

//        $user = User::create($request->only('name', 'email', 'password', 'phone', 'status'));
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $user->phone = $request->phone;
        $user->id_role = 5;
        $user->note = $request->note;

        $user->save();

        $company = new Company();
        $company->id_user = $user->id;
        $company->fields = $request->fields;
        $company->introduce = $request->introduce;
        $company->address = $request->address;

        $company->save();

        return 1;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ],
            [
                'name.required' => 'Mời nhập tên doanh nghiệp',
                'email.required' => 'Mời nhập email',
                'email.email' => 'Email không tồn tại',
                'passwrod.required' => 'Mời nhập mật khẩu',
            ]);

        $company = Company::find($id);
        $company->update($request->only('fields', 'id_user', 'introduce', 'address'));

        $user = User::find($request->id_user);
        $user->update($request->only('name', 'email', 'password', 'phone', 'status'));

        return 1;
    }

    public function delete($id)
    {
        $company = Company::find($id);

        User::find($company->id_user)->delete();
        $company->delete();

        return 1;
    }
}
