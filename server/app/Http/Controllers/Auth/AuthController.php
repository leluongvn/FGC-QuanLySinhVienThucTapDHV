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
//        $credentials = $request->only(['email', 'password']);

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
