<?php

namespace App\Api\Controllers;

use Dingo\Api\Http\Request;
use App\Article;
use App\Comment;
use App\Library\EcjtuNet\UserCenter;

class CommentController extends Controller
{
    /**
     * @api {post} /article/:id/comment 提交评论
     * @apiVersion 1.0.0
     * @apiName PostComment
     * @apiGroup Comment
     *
     * @apiParam {Number} id 文章ID
     * @apiParam {String} content 评论内容
     *
     * @apiSuccess {Number} id 文章ID
     * @apiSuccess {String} content 评论内容
     */
    public function submit(Request $request, $id)
    {
        $article = Article::published()->findOrFail($id);
        $content = $request->input('content');
        $content = htmlspecialchars($content);
        if (str_replace(' ', '', $content) == '') {
            throw new Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
        $sid = $request->input('sid');
        $token = $request->input('token');
        $uc = new UserCenter();
        $user = $uc->getUser($sid, $token);
        if (!$user) {
            throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
        $comment = new Comment(['author' => $sid, 'content' => $content]);
        $article->comments()->save($comment);

        return ['status' => 200, 'content' => $content];
    }
}
