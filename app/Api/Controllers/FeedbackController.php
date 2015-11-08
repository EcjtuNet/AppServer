<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use App\Feedback;

class VersionController extends Controller
{
    public function submit()
    {
        $nikename = Request::input('nickname');
        $content = Request::input('content');
        if (!$content) {
            return [
                'status' => false,
                'msg' => '请输入内容',
                ];
        }
        $feedback = Feedback::create([
            'nikename' => $nikename,
            'content' => $content,
            ]);
        return ['status' => 200];
    }
}
