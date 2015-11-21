<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
    public function submit(Request $request)
    {
        if (!$request->file('upload_file')) {
            return;
        }
        $file = $request->file('upload_file');
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension != 'jpg') {
            return json_encode(['success' => false, 'msg' => '请使用jpg格式图片']);
        }
        $filename = strval(time()).strval(rand(100, 999)).'.jpg';
        Storage::put('uploads/'.$filename, file_get_contents($file->getRealPath()));

        return json_encode([
            'success'   => true,
            'msg'       => '上传成功',
            'file_path' => '/uploads/'.$filename,
            ]);
    }
}
