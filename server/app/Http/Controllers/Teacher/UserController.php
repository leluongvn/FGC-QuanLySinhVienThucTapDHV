<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Model\Internship_Time;
use App\Model\Internship_Topic;
use App\Model\Role;
use App\Model\Student;
use App\Model\Teacher;
use App\Model\User;
use App\Model\View_Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function getDetail($id, $time)
    {
        $data = View_Profile::with('point')->where('teacher_id', $id)->where('id_internship_time', $time)->get();

        foreach ($data as $val) {
            $val['topic'] = is_null($val['point']) ? '' : Internship_Topic::with('topic')->find($val['point']->id_internship_topic)->topic->name;
            $val['point'] = is_null($val['point']) ? '' : $val['point'];
            $val['student'] = Student::with('user')->find($val->reg->id_student);
        }
        return response()->json($data);
    }

    public function changeStatus(Request $request, $id)
    {
        $user = User::find(Teacher::find($id)->id_user);
        $user->update([
            'status' => $user->status == 1 ? 0 : 1
        ]);

        return 1;
    }

    public function excel(Request $request, $id)
    {
        try {
            foreach ($request->data as $item) {

                $user = User::updateOrCreate(['email' => $item['Email']], ['name' => $item['Tên giảng viên'], 'phone' => $item['Điện thoại'], 'id_role' => 4, 'password' => app('hash')->make($item['Mã giảng viên'])]);
                Teacher::updateOrCreate(['msgv' => $item['Mã giảng viên']], ['id_subject' => $id, 'id_user' => $user->id]);
            }
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function getUser()
    {
        // return Auth::user()->id;
        $data = DB::table('users as u')
            ->select('t.id', 't.msgv', 't.id_user', 't.id_subject', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
            ->join('teachers as t', 't.id_user', 'u.id')
            ->where('u.id', Auth::user()->id)
            ->first();
        return response()->json($data);
    }

    public function getTldt()
    {
        $data = DB::table('users as u')
            ->select('u.id', 'u.name')
            ->join('teachers as t', 't.id_user', 'u.id')
            ->where('u.id_role', 2)
            ->first();
        return response()->json($data);
    }

    public function postTldt(Request $request)
    {
        if (isset($request->old_id)) {
            $old_user = User::find($request->old_id);
            $old_user->id_role = 4;
            $old_user->save();
        }
        $new_user = User::find(Teacher::find($request->new_id)->id_user);

        $new_user->id_role = 2;
        $new_user->save();
        return 1;
    }

    public function getTbm($id)
    {
        $data = DB::table('users as u')
            ->select('u.id', 'u.name')
            ->join('teachers as t', 't.id_user', 'u.id')
            ->join('subjects as s', 't.id_subject', 's.id')
            ->where('t.id_subject', $id)
            ->where('u.id_role', 3)
            ->first();
        return response()->json($data);
    }

    public function postTbm(Request $request)
    {
        if (isset($request->old_id)) {
            $old_user = User::find($request->old_id);

            $old_user->id_role = 4;
            $old_user->save();
        }
        $new_user = User::find(Teacher::find($request->new_id)->id_user);

        $new_user->id_role = 3;
        $new_user->save();
        return 1;
    }

    public function getTeachers()
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Trưởng bộ môn") {
            $sub = Teacher::where('id_user', Auth::user()->id)->get();
            $data = DB::table('users as u')
                ->select('t.id', 't.msgv', 't.id_user', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
                ->join('teachers as t', 't.id_user', 'u.id')
                ->where('u.status', 1)
                ->where('t.id_subject', $sub[0]->id_subject)
                ->get();
            return $data;
        } else if ($role->name === "Admin") {
            $data = DB::table('users as u')
                ->select('t.id', 't.msgv', 't.id_user', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
                ->join('teachers as t', 't.id_user', 'u.id')
                ->where('u.status', 1)
                ->get();
            return $data;
        }
    }

    public function all()
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Admin") {
            $data = DB::table('users as u')
                ->select('t.id', 'u.id as id_user', 't.msgv', 't.id_user', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
                ->join('teachers as t', 't.id_user', 'u.id')
                ->where('status', 1)
                ->get();
            return $data;
        }
    }

    public function showSubjectTeachers($subject)
    {
        $role = Role::find(Auth::user()->id_role);
        if ($role->name === "Admin") {
            $data = DB::table('users as u')
                ->select('t.id', 't.msgv', 't.id_user', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
                ->join('teachers as t', 't.id_user', 'u.id')
                ->where('t.id_subject', $subject)
                ->get();
            return $data;
        }
    }

    public function showOneTeachers($id)
    {
        $data = DB::table('users as u')
            ->select('t.id', 't.msgv', 't.id_user', 't.id_subject', 'u.name', 'u.email', 'u.phone', 't.fields', 'u.status', 'u.note')
            ->join('teachers as t', 't.id_user', 'u.id')
            ->where('t.id', $id)
            ->get();
        return $data;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
                'msgv' => 'required|max:20|min:10|unique:teachers',
                'name' => 'required',
                'email' => 'email|unique:users',
                'id_subject' => 'exists:subjects,id'
            ]
            ,
            [
                'msgv.required' => 'Mời nhập mã giảng viên',
                'msgv.unique' => 'Mã giảng viên đã tồn tại',
                'msgv.max' => 'Mã giảng viên phải nhỏ hơn 20 ký tự',
                'msgv.min' => 'Mã giảng viên phải lớn hơn 10 ký tự',
                'name.required' => 'Mời nhập tên sinh viên',
                'email.required' => 'Mời nhập Email',
                'email.unique' => 'Email đã tồn tại',
                'email.email' => 'Email không hợp lệ',
                'id_subject.exists' => 'Bộ môn không tồn tại'
            ]);

//        $user = User::create($request->only('name', 'email', 'password', 'phone','id_role', 'status'));
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->msgv);
        $user->phone = $request->phone;
        $user->id_role = 4;
        $user->note = $request->note;

        $user->save();

        $teacher = new Teacher();
        $teacher->msgv = $request->msgv;
        $teacher->id_subject = $request->id_subject;
        $teacher->id_user = $user->id;
        $teacher->fields = $request->fields;

        $teacher->save();

        return response()->json($teacher, 200);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'msgv' => 'required|max:20|min:10',
            'name' => 'required',
            'email' => 'email|required',
            'id_subject' => 'exists:subjects,id'
        ],
            [
                'msgv.required' => 'Mời nhập Mã giảng viên',
                'msgv.max' => 'Mã giảng viên phải nhỏ hơn 20 ký tự',
                'msgv.min' => 'Mã giảng viên phải lớn hơn 10 ký tự',
                'name.required' => 'Mời nhập tên sinh viên',
                'email.required' => 'Mời nhập Email',
                'email.email' => 'Email không hợp lệ',
                'id_subject.exists' => 'Bộ môn không tồn tại'
            ]);

        $teacher = Teacher::find($id);
        $teacher->update($request->only('msgv', 'id_subject', 'id_user', 'fields'));

        $user = User::find($request->id_user);
        $user->update($request->only('name', 'email', 'phone', 'status'));

        return 1;
    }

    public function delete($id)
    {
        $user = Teacher::find($id);
        if (sizeof($user->instructor) <= 0) {
            $user->delete();
            $user->user()->delete();
            return response()->json(1, 200);
        } else {
            return response()->json(0, 500);
        }
    }
}
