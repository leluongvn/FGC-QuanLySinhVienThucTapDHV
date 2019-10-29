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
        return response()->json(Student::where('id', $id)->first());
    }
    public function create(Request $request)
    {
        /**
         * Thêm mới một sinh viên
         */
        $this->validate($request, [
            'id_student' => 'required|unique:students|max:20|min:10',
            'course_id'  => 'required',
            'password'   => 'required|min:6',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ],
        [
            'id_student.required' => 'Vui lòng nhập mã sinh viên',
            'id_student.unique'   => 'Mã sinh viên đã tồn tại',
            'id_student.max'      => 'Độ dài mã sinh viên phải nhỏ hơn 20 ký tự',
            'id_student.min'      => 'Độ dài mã sinh viên phải lớn hơn 10 ký tự',
            'id_course.required'  => 'Vui lòng lựa chọn khóa học',
            'password.required'   => 'Vui lòng thêm mật khẩu',
            'first_name.required' => 'Vui lòng nhập họ',
            'last_name.required'  => 'Vui lòng nhập tên ',
            'email.email'         => 'Không phải email',
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
            'id_student' => 'required|max:20|min:10',
            'course_id'  => 'required',
            'password'   => 'required|min:6',
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email',
        ],
        [
            'id_student.required' => 'Vui lòng nhập mã sinh viên',
            'id_student.max'      => 'Độ dài mã sinh viên phải nhỏ hơn 20 ký tự',
            'id_student.min'      => 'Độ dài mã sinh viên phải lớn hơn 10 ký tự',
            'id_course.required'  => 'Vui lòng lựa chọn khóa học',
            'password.required'   => 'Vui lòng thêm mật khẩu',
            'first_name.required' => 'Vui lòng nhập họ',
            'last_name.required'  => 'Vui lòng nhập tên ',
            'email.email'         => 'Không phải email',
        ]);
        $Student = Student::where('id', $id)->first();
        $Student->update($request->all());
        return response()->json($Student, 200);
    }
    public function delete($id)
    {
        /**
         * Xóa sinh viên theo id
         */
        $Student = Student::where('id', $id)->first();
        $Student->delete();
        return response('Thực hiện thành công !', 200);
    }
}
