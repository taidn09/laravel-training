<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;

class UploadController extends Controller
{
    public function index(Request $request){
        $where = $request->post('where');
        if($request->hasFile('file') && $request->file->isValid()){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = md5(uniqid().time()). '.' . $extension;
            $path = $file->storeAs( $where, $fileName );
            return toJSON(true, 'Upload hình ảnh thành công!', ['link' => $path]);
        }
        return false;
    }
}
