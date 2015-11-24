<?php

namespace App\Api\Controllers;

use Dingo\Api\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    /**
     * @api {post} /feedback 提交反馈
     * @apiVersion 1.0.0
     * @apiName PostFeedback
     * @apiGroup Feedback
     *
     * @apiParam {String} nickname 昵称
     * @apiParam {String} content 反馈内容
     *
     * @apiSuccess {Number} status 状态码
     */
    public function submit(Request $request)
    {
        $nickname = $request->input('nickname');
        $content = $request->input('content');
        if (!$content) {
            return [
                'status' => false,
                'msg'    => '请输入内容',
                ];
        }
        $feedback = Feedback::create([
            'nickname' => $nickname,
            'content'  => $content,
            ]);

        return ['status' => 200];
    }
}
