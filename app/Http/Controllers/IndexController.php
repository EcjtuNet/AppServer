<?php

namespace App\Http\Controllers;

use App\Log;
use App\Setting;
use Illuminate\Http\Response;
use Storage;

class IndexController extends Controller
{
    public function download()
    {
        $setting = Setting::find('apk');
        if (!$setting) {
            return redirect('/');
        }
        $apk = $setting->value;
        $file = Storage::get('uploads/'.$apk);
        Log::record('download', $apk);

        return (new Response($file, 200))
            ->header('Content-Type', 'application/vnd.android.package-archive');
    }

    public function show()
    {
        $version_name = Setting::find('version_name');

        return view('index', [
            'version_name' => $version_name->value,
            'published_at' => $version_name->updated_at->toDateString(),
        ]);
    }
}
