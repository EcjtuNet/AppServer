<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use App\Article;
use App\Comment;
use App\Library\EcjtuNet\UserCenter;

class CommentController extends Controller
{
    public function submit()
    {
        $article = Article::published()->findOrFail($id);
        $content = Request::input('content');
        $content = htmlspecialchars($content);
        if (str_replace(' ', '', $content) == '') {
            throw new Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
        }
        $sid = Request::input('sid');
        $token = Request::input('token');
        $uc = new UserCenter();
        $user = $uc->getUser($sid, $token);
        if (!$user) {
            throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
        }
        $comment = new Comment(['author'=>$sid, 'content'=>$content]);
        $article->comments()->save($comment);
        return ['status' => 200, 'content' => $content];
    }
}
