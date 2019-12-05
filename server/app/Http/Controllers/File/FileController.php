<?php

namespace App\Http\Controllers\File;
use App\Http\Controllers\Controller;
use App\Model\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        
    }

    public function show()
    {
        return response()->json(File::all());
    }

    public function showOne($id)
    {
        return response()->json(File::find($id));
    }

    public function doUpload(Request $req){
        if ($req->hasFile('filesPath')) {
            $file = $req->filesPath;
            $newName=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'_'.$file->hashName();
            $file->move('upload',$newName);
            $data= new File;
            $data->name=$newName;
            $data->save();
            return 1;
        }
    }

    public function doDownload($id){
        $file=File::find($id);
        $path='upload/'.$file->name;
        return response()->download(env('PUBLIC_PATH', base_path('public')) . ($path ? '/' . $path : $path));
    }
}
