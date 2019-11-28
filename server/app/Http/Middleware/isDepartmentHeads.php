<?php

namespace App\Http\Middleware;

const IS_ADMIN               = 1;
const IS_TRAINNING_ASSISTANT = 2;
const IS_DEPARTMENT_HEADS    = 3;  
const IS_TEACHER             = 4;
const IS_COMPANY             = 5;
const IS_STUDENT             = 6;

use Closure;

class isDepartmentHeads
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */

    /**
     * Kiểm tra user vừa đăng nhập có phải là trưởng bộ môn? 
     */
    protected $auth;

    public function handle($request, Closure $next, $guard = null)
    {
        /**
         *  lấy ra id_role của user vừa đăng nhập
         */
        foreach($request->user()->roles as $roles){
            $role = $roles->pivot->first()->id_role;
        }
        /**
         *  kiểm tra role là admin hoặc trưởng bộ môn
         */
        if ( $role != IS_ADMIN && $role != IS_DEPARTMENT_HEADS) {
            return response('Bạn không đủ quyền để truy cập.', 403);
        }

        return $next($request);
    }
}
