<?php

namespace App\Http\Middleware;
const IS_ADMIN               = 1;
const IS_TRAINNING_ASSISTANT = 2;
const IS_DEPARTMENT_HEADS    = 3;
const IS_TEACHER             = 4;
const IS_COMPANY             = 5;
const IS_STUDENT             = 6;

use Closure;

class isAdmin
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    public function handle($request, Closure $next, $guard = null)
    {
        foreach($request->user()->roles as $roles){
            $role = $roles->pivot->first()->id_role;
        }
        if ( $role != IS_ADMIN) {
            return response('k phai la admin .', 403);
        }

        return $next($request);
    }
}
