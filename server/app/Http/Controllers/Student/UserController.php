<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Internship_Time;
use App\Model\Internship_Topic;
use App\Model\Internship_Type;
use App\Model\Student;
use App\Model\Student_Reg;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function delMuti(Request $request)
    {
        foreach ($request->data as $val) {
            $user = Student::with('reg')->find($val['id']);
            if (sizeof($user['reg']) <= 0) {
                $user = Student::find($val['id']);
                $user->delete();
                $user->user()->delete();
            }
        }
        return 1;
    }

    public function excel(Request $request)
    {
        try {
            foreach ($request->data as $item) {

                $user = User::updateOrCreate(['email' => $item['Email']], ['name' => $item['Tên sinh viên'], 'id_role' => 6, 'password' => app('hash')->make($item['Mã sinh viên'])]);
                Student::updateOrCreate(['mssv' => $item['Mã sinh viên']], ['id_user' => $user->id, 'class' => $item['Lớp']]);
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getDetail($id)
    {
        $student = Student::with('reg')->find($id);
        $ids = array_column(($student->reg)->toArray(), 'id');

        $data = Student_Reg::with('profile', 'point', 'internship')->whereIn('id', $ids)->get();

        foreach ($data as $val) {
            $val['topic'] = is_null($val['point']) ? '' : Internship_Topic::with('topic')->find($val['point']->id_internship_topic)->topic->name;
            $val['point'] = is_null($val['point']) ? '' : $val['point'];
            $val['type'] = Internship_Time::with('internship_type')->find($val->id_internship_time)->internship_type->name;
        }


        return response()->json($data);
    }

    public function changeStatus(Request $request, $id)
    {
        $user = User::find(Student::find($id)->id_user);
        $user->update([
            'status' => $user->status == 0 ? 1 : 0
        ]);
        return 1;
    }

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
            ->select('s.id', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'u.status', 'u.note')
            ->join('students as s', 's.id_user', 'u.id')
            ->where('s.id', $id)
            ->get();

        return $data;
    }

    public function getUser()
    {
        $data = DB::table('users as u')
            ->select('s.id', 's.id_user', 'u.name', 'u.email', 'u.phone', 's.mssv', 's.birthday', 's.class', 'u.status', 'u.note')
            ->join('students as s', 's.id_user', 'u.id')
            ->where('u.id', Auth::user()->id)
            ->first();

        return response()->json($data);
    }

    public function create(Request $request)
    {
        /**
         * Thêm mới một sinh viên
         */
        $this->validate($request, [
            'mssv' => 'required|max:20|min:10|unique:students',
            'name' => 'required',
            'email' => 'email|required|unique:users'
        ],
            [
                'mssv.required' => 'Mời nhập mssv',
                'mssv.unique' => 'Mã sinh viên đã tồn tại',
                'mssv.max' => 'Mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min' => 'Mã sinh viên phải lớn hơn 10 ký tự',
                'name.required' => 'Mời nhập tên sinh viên',
                'email.required' => 'Mời nhập Email',
                'email.unique' => 'Email đã tồn tại',
                'email.email' => 'Email không hợp lệ'
            ]
        );

//        $user = User::create($request->only('name', 'email', 'password', 'phone', 'status'));
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->mssv);
        $user->phone = $request->phone;
        $user->id_role = 6;
        $user->note = $request->note;

        $user->save();

        $student = new Student();
        $student->mssv = $request->mssv;
        $student->id_user = $user->id;
        $student->birthday = $request->birthday;
        $student->class = $request->class;

        $student->save();

        return $student;
    }

    public function update(Request $request, $id)
    {
        /**
         * Cập nhật một sinh viên theo id
         */
        $this->validate($request, [
            'mssv' => 'required|max:20|min:10',
            'name' => 'required',
            'email' => 'email|required'
        ],
            [
                'mssv.required' => 'Mời nhập mssv',
                'mssv.max' => 'Mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min' => 'Mã sinh viên phải lớn hơn 10 ký tự',
                'name.required' => 'Mời nhập tên sinh viên',
                'email.required' => 'Mời nhập Email',
                'email.email' => 'Email không hợp lệ']
        );

        $student = Student::find($id);
        $student->update($request->only('mssv', 'birthday', 'id_user', 'class'));

        $user = User::find($request->id_user);
        $user->update($request->only('name', 'email', 'phone', 'status', 'note'));

        return 1;
    }

    public function delete($id)
    {
        /**
         * Xóa sinh viên theo id
         */

        $user = Student::find($id);
        if (sizeof($user->reg) <= 0) {
            $user->delete();
            $user->user()->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }
    }
}
