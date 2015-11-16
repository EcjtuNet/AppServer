<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use Dingo\Api\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    public function submit(Request $request)
    {
        $nikename = $request->input('nickname');
        $content = $request->input('content');
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
