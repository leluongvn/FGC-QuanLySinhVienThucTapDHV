<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Model\Teacher;
use Illuminate\Http\Request;
use Excel;
// use Illuminate\Support\Facades\Input as Input;



class TeacherController extends Controller
{
    public function showAllTeachers()
    {
        return response()->json(Teacher::all());
    }

    public function showOneTeachers($id)
    {
        return response()->json(Teacher::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'msgv' => 'required|max:20|min:10',
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
        ],
            [
                'msgv.required' => 'Vui lòng nhập mã giảng viên',
                'msgv.max' => 'Độ dài mã giảng viên phải nhỏ hơn 20 ký tự',
                'msgv.min' => 'Độ dài mã giảng viên phải lớn hơn 10 ký tự',
                'name.required' => 'Vui lòng nhập tên',
                'phone.required' => 'Vui lòng nhập số điện thoại ',
                'email.email' => 'Không phải email',
            ]);

        $teacher = Teacher::create($request->all());

        return response()->json($teacher, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'msgv' => 'required|max:20|min:10',
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
        ],
            [
                'msgv.required' => 'Vui lòng nhập mã giảng viên',
                'msgv.max' => 'Độ dài mã giảng viên phải nhỏ hơn 20 ký tự',
                'msgv.min' => 'Độ dài mã giảng viên phải lớn hơn 10 ký tự',
                'name.required' => 'Vui lòng nhập tên',
                'phone.required' => 'Vui lòng nhập số điện thoại ',
                'email.email' => 'Không phải email',
            ]);
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());

        return response()->json($teacher, 200);
    }

    public function delete($id)
    {
        Teacher::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function importExcel(Request $request)
    {
      
        if($request->hasFile('import_file')){
			$path = $request->file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if($data && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = ['msgv' => $value->msgv, 'id_subject' => $value->id_subject, 'name' => $value->name, 'password' => $value->password, 'email' => $value->email, 'phone' => $value->phone, 'introduce' => $value->introduce, 'note' => $value->note];                    
                }
				if($insert){
                    // DB::table('teacher')->insert($insert);
                    $teacher= Teacher::insert($insert);
                    return response()->json($teacher, 201);					
                }                
            }            
		}		
    }
}
