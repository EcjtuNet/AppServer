<?php

namespace App\Api\Controllers;

use Dingo\Api\Http\Request;
use App\Check;

class CheckController extends Controller{

    public function submit(Request $request)
    {
        /**
         * @api {post} /check 签到
         * @apiVersion 1.0.0
         * @apiName PostCheck
         * @apiGroup Check
         *
         * @apiParam {String} sid 学号
         *
         * @apiSuccess {Boolean} status 状态码
         * @apiSuccess {String} msg 返回说明
         * @apiSuccess {int} times 总签到数
         * @apiSuccess {int} combos 连续签到数
         * @apiSuccess {int} marks 积分
        **/
        $sid = $request->input('sid');
        $user = Check::find($sid);
        $today = date("Y-m-d", time());
        $yesterday = date("Y-m-d", time() - 86400);
        if ($user) {
            $last = $user->check_last;
            if($last == $today ){
                return[
                    'status'=> false,
                    'msg' => '今天你已经签过啦~',
                    'times' => $user->times,
                    'combos' => $user->combos,
                    'marks' => $user->marks
                ];
            }
            if($last == $yesterday){
                $user->increment('times',1);
                $user->increment('combos',1);
                $user->increment('marks',2);
                return [
                    'status'=>true,
                    'msg' => '恭喜签到成功',
                    'times' => $user->times,
                    'combos' => $user->combos,
                    'marks' => $user->marks
                ];
            }else{
                $user->increment('times',1);
                $user->increment('marks',1);
                $user->update(['combos'=>0]);
                return [
                    'status'=>true,
                    'msg' => '恭喜签到成功',
                    'times' => $user->times,
                    'combos' => $user->combos,
                    'marks' => $user->marks
                ];
            }
        }else {
            Check::create([
                'id' => $sid,
                'check_last' => $today
            ]);
            return[
                'status'=>true,
                'msg' => '恭喜第一次签到成功',
                'times' =>1,
                'combos'=>1,
                'marks'=>5
            ];
        }
    }
}