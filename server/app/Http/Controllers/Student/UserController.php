<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAll()
    {
        /**
         *  Trả về tất cả sinh viên
         */
        $data = DB::table('users as u')
            ->select('s.id', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'u.status')
            ->join('students as s', 's.id_user', 'u.id')
            ->get();

        return $data;
    }

    public function getSingle($id)
    {
        /**
         *  Trả về một sinh viên theo id
         */
        $data = DB::table('users as u')
            ->select('s.id', 's.id_user', 'u.name','u.password', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'u.status','u.note')
            ->join('students as s', 's.id_user', 'u.id')
            ->where('s.id', $id)
            ->get();

        return $data;
    }

    public function create(Request $request)
    {
        /**
         * Thêm mới một sinh viên
         */
        $this->validate($request, [
                'mssv' => 'required|max:20|min:10|unique:students',
                'name' => 'required',
                'email' => 'email|required|unique:users',
                'password' => 'required'
            ],
            [
                'mssv.required'=>'Mời nhập mssv',
                'mssv.unique'=>'Mã sinh viên đã tồn tại',
                'mssv.max'=>'Mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min'=>'Mã sinh viên phải lớn hơn 10 ký tự',
                'name.required'=>'Mời nhập tên sinh viên',
                'email.required'=>'Mời nhập Email',
                'email.unique'=>'Email đã tồn tại',
                'email.email'=>'Email không hợp lệ',
                'password.required'=>'Mời nhập mật khẩu'
            ]
        );

        $user = User::create($request->only('name', 'email', 'password', 'phone', 'status'));

        $student = new Student();
        $student->mssv = $request->mssv;
        $student->id_user = $user->id;
        $student->birthday = $request->birthday;
        $student->class = $request->class;

        $student->save();

        return 1;
    }

    public function update(Request $request, $id)
    {
        /**
         * Cập nhật một sinh viên theo id
         */
        $this->validate($request, [
            'mssv' => 'required|max:20|min:10',
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required',
            ],
            [
                'mssv.required'=>'Mời nhập mssv',
                'mssv.max'=>'Mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min'=>'Mã sinh viên phải lớn hơn 10 ký tự',
                'name.required'=>'Mời nhập tên sinh viên',
                'email.required'=>'Mời nhập Email',
                'email.email'=>'Email không hợp lệ',
                'password.required'=>'Mời nhập mật khẩu',
            ]
        );

        $student = Student::find($id);
        $student->update($request->only('mssv', 'birthday', 'id_user', 'class'));

        $user = User::find($request->id_user);
        $user->update($request->only('name', 'email', 'password', 'phone', 'status','note'));

        return 1;
    }

    public function delete($id)
    {
        /**
         * Xóa sinh viên theo id
         */
        $student = Student::find($id);

        User::find($student->id_user)->delete();
        $student->delete();

        return 1;
    }
}
