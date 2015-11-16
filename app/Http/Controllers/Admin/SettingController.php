<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Storage;

class SettingController extends Controller
{
    public function show()
    {
        $version_name = Setting::find('version_name');
        $version_name = $version_name ? $version_name->value : '';
        $version_code = Setting::find('version_code');
        $version_code = $version_code ? $version_code->value : '';
        return view('admin.settings', [
            'active' => 'settings',
            'version_name' => $version_name,
            'version_code' => $version_code,
            ]);
    }

    public function submit(Request $request)
    {
        if ($request->file('upload_file')) {
            if (!$request->file('upload_file')->isValid()) {
                return redirect()->route('admin_setting');
            }
            $file = $request->file('upload_file');
            $extension = strtolower($file->getClientOriginalExtension());
            if($extension != 'apk') {
                return redirect()->route('admin_setting');
            }
            $filename = $file->getFilename() . '.' . $extension;
            Storage::put('uploads/'. $filename, file_get_contents($file->getRealPath()));
            $setting = Setting::firstOrCreate(array('key'=>'apk'));
            $setting->value = $filename;
            $setting->save();
        }

        $available = ['version_code', 'version_name'];
        $data = $request->only($available);
        foreach ($data as $key => $value) {
            $row = Setting::firstOrCreate(array('key' => $key));
            $row->value = $value;
            $row->save();
        }
        return redirect()->route('admin_setting');
    }
    
}
