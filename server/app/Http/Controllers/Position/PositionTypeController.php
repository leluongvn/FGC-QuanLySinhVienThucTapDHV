<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use App\Model\Position_Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionTypeController extends Controller
{
    public function getAll(){
        return Position_Type::all();
    }
}
