<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Model\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAll()
    {
        /**
         *  Trả về tất cả sinh viên
         */
        return response()->json(Student::all());
    }

    public function getSingle($id)
    {
        /**
         *  Trả về một sinh viên theo id
         */
        return response()->json(Student::find($id));
    }

    public function create(Request $request)
    {
        /**
         * Thêm mới một sinh viên
         */
        $this->validate($request, [
            'mssv' => 'required|max:20|min:10',
            'name' => 'required',
            'class' => 'required',
            'email' => 'email',
            'date_birth' => 'required',
//            'phone' => 'required',
        ],
            [
                'mssv.required' => 'Vui lòng nhập mã sinh viên',
                'mssv.max' => 'Độ dài mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min' => 'Độ dài mã sinh viên phải lớn hơn 10 ký tự',
                'name.required' => 'Vui lòng nhập tên',
                'class.required' => 'Vui lòng nhập lớp',
                'date_birth.required' => 'Vui lòng nhập ngày sinh ',
//                'phone.required' => 'Vui lòng nhập số điện thoại ',
                'email.email' => 'Không phải email',
            ]);
        $Student = Student::create($request->all());
        return response()->json($Student, 201);
    }

    public function update(Request $request, $id)
    {
        /**
         * Cập nhật một sinh viên theo id
         */
        $this->validate($request, [
            'mssv' => 'required|max:20|min:10',
            'name' => 'required',
            'class' => 'required',
            'email' => 'email',
            'date_birth' => 'required',
//            'phone' => 'required',
        ],
            [
                'mssv.required' => 'Vui lòng nhập mã sinh viên',
                'mssv.max' => 'Độ dài mã sinh viên phải nhỏ hơn 20 ký tự',
                'mssv.min' => 'Độ dài mã sinh viên phải lớn hơn 10 ký tự',
                'name.required' => 'Vui lòng nhập tên',
                'class.required' => 'Vui lòng nhập lớp',
                'date_birth.required' => 'Vui lòng nhập ngày sinh ',
//                'phone.required' => 'Vui lòng nhập số điện thoại ',
                'email.email' => 'Không phải email',
            ]);
        $Student = Student::find($id);
        $Student->update($request->all());
        return response()->json($Student, 200);
    }

    public function delete($id)
    {
        /**
         * Xóa sinh viên theo id
         */
        $Student = Student::find($id);
        $Student->delete();
        return response('Thực hiện thành công !', 200);
    }
}
