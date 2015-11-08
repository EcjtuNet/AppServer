<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use App\Setting;

class VersionController extends Controller
{
    public function show()
    {
        return [
            'status' => 200,
            'version_name' => Setting::find('version_name')->value,
            'version_code' => Setting::find('version_code')->value,
        ];
    }
}
