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
    { }

    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate(
            $request,
            [
                'email'    => 'required',
                'password' => 'required',
            ],
            [
                'email.required'    => 'Mời nhập email',
                'password.required' => 'Mời nhập mật khẩu',
            ]
        );

        $credentials = $request->only(['email', 'password']);
    
        if ($token = Auth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
