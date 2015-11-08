<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Push;
use JPush\Model as M;
use JPush\JPushClient as JPush;

class PushController extends Controller
{
    public function showList()
    {
        $pushes = Push::with('article')->orderBy('created_at', 'desc')->paginate(10);
        $msg_list = $pushes->lists('msg_id');
        if( $msg_list->isEmpty() ) {
            return view('admin.push', [
                'active' => 'push',
                'pushes' => [],
                ]);
        }
        $msg_ids = implode(',', $msg_list->toArray());
        $jpush = new JPush(config('jpush.app_key'), config('jpush.master_secret'));
        $result = $jpush->report($msg_ids)->received_list;
        $pushes = $pushes->each(function ($push) use ($result) {
            foreach ($result as $row) {
                if($push->msg_id == $row->msg_id && $row->android_received > $push->received) {
                    $push->received = $row->android_received;
                    break;
                }
            }
            $push->save();
            return $push;
        });
        return view('admin.push', [
            'active' => 'push',
            'pushes' => $pushes,
            ]);
    }

    public function submit(Request $request)
    {
        $message = $request->input('message');
        $title = $request->input('title', '日新网手机客户端');
        $aid = intval($request->input('aid'));
        if (!$message || !$aid) {
            return redirect()->route('admin_push_list');
        }
        if (mb_strlen($title) > 10 || mb_strlen($message) > 16) {
            return redirect()->route('admin_push_list');
        }
        if (!Article::find($aid)) {
            return redirect()->route('admin_push_list');
        }
        $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('article_view', $aid);
        $jpush = new JPush(config('jpush.app_key'), config('jpush.master_secret'));
        $result = $jpush->push()
            ->setPlatform(M\all)
            ->setAudience(M\all)
            ->setNotification(M\notification(M\android($message, $title, 1, array("articleId"=>$aid, "url"=>$url))))
            ->send();
        $push = Push::create(array(
            'msg_id' => $result->msg_id,
            'title' => $title,
            'message' => $message,
            'article_id' => $aid,
        ));
        $push->save();
        return redirect()->route('admin_push_list');
    }
}
