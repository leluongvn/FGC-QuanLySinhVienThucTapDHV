<?php

namespace App\Http\Controllers;
use App\Model\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        $user = Auth::user();
        $role = Role::find($user->id_role);
        return response()->json([
            'token' => $token,
//            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'role' => $role->name,
            'user' => $user->name
        ], 200);
    }
}
