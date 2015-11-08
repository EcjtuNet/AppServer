<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Image;

class ImageController extends Controller
{
    public function submit(Request $request)
    {
        if (!$request->file('upload_file')) {
            return ;
        }
        $file = $request->file('upload_file');
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension != 'jpg') {
            return json_encode(['success' => false, 'msg' => '请使用jpg格式图片']);
        }
        $filename = strval(time()) . strval(rand(100,999)) . '.jpg';
        Storage::put('uploads/' . $filename, File::get($file));
        return json_encode([
            'success' => true, 
            'msg' => '上传成功', 
            'file_path' => '/uploads/' . $filename
            ]);
    }
}
