<?php

namespace App\Api\Controllers;

use App\Setting;

class VersionController extends Controller
{
    /**
     * @api {get} /version App版本号
     * @apiVersion 1.0.0
     * @apiName GetVersion
     * @apiGroup Version
     * 
     * @apiSuccess {Number} status 状态码
     * @apiSuccess {String} version_name 版本名
     * @apiSuccess {Number} version_code 版本号
     */
    public function show()
    {
        return [
            'status'       => 200,
            'version_name' => Setting::find('version_name')->value,
            'version_code' => Setting::find('version_code')->value,
        ];
    }
}
