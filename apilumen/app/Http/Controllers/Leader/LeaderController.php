<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Model\Leader;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function getAll()
    {
        /**
         *  Lấy tất cả nhóm trưởng
         */
        return response()->json(Leader::all());
    }
    public function getSingle($id)
    {
        /**
         *  Trả về một nhóm theo id 
         */
        return response()->json(Leader::where('id', $id)->first());
    }
    public function create(Request $request)
    {
        /**
         * Thêm mới một sinh viên
         */
        $this->validate(
            $request,
            [
                'id_student_reg' => 'required|exists:student_regs,id',
                'id_position'    => 'required',
            ],
            [
                'id_student_reg.required' => 'Vui lòng chọn mã sinh viên',
                'id_student_reg.exists'   => 'Mã sinh viên chưa được đăng ký',
                'id_position.required'    => 'Vui lòng chọn vị trí',

            ]
        );
        $Leader = Leader::create($request->all());
        return response()->json($Leader, 201);
    }
    public function update(Request $request, $id)
    {
        /**
         * Cập nhật một sinh viên theo id
         */
        $this->validate(
            $request,
            [
                'id_student_reg' => 'required|exists:student_regs,id',
                'id_position'    => 'required',
            ],
            [
                'id_student_reg.required' => 'Vui lòng chọn mã sinh viên',
                'id_student_reg.exists'   => 'Mã sinh viên chưa được đăng ký',
                'id_position.required'    => 'Vui lòng chọn vị trí',

            ]
        );
        $Leader = Leader::where('id', $id)->first();
        $Leader->update($request->all());
        return response()->json($Leader, 200);
    }
    public function delete($id)
    {
        /**
         * Xóa sinh viên theo id
         */
        $Leader = Leader::where('id', $id)->first();
        $Leader->delete();
        return response('Thực hiện thành công !', 200);
    }
}
