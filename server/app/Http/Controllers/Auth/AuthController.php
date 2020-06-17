<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {

    }

    public function password(Request $request)
    {
        $this->validate(
            $request,
            [
                'old' => 'required',
                'new' => 'required',
                'config' => 'required',
            ],
            [
                'old.required' => 'Mời nhập mật khẩu cũ',
                'new.required' => 'Mời nhập mật khẩu mới',
                'config.required' => 'Mời nhập lại mật khẩu',
            ]
        );

        if ($request->new == $request->config && app('hash')->check($request->old, Auth::user()->getAuthPassword())) {
            User::find(Auth::user()->id)->update(['password' => app('hash')->make($request->new)]);
            return response()->json(['message' => 'ok'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Mời nhập email',
                'password.required' => 'Mời nhập mật khẩu',
            ]
        );

        $data = collect($request->all())->merge([
            'status' => 1
        ])->toArray();

        if ($token = Auth::attempt($data)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function check()
    {
        return Auth::user();
    }
}
