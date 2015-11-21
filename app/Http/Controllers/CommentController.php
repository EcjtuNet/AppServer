<?php

namespace App\Http\Controllers;

use App\Article;
use App\Library\EcjtuNet\UserCenter;

class CommentController extends Controller
{
    public function showComments($id)
    {
        $article = Article::with('comments')->published()->findOrFail($id);
        $comments = $article->comments;
        $article->increClick();
        $comments = $comments->each(function ($comment) {
            $sid = $comment->author;
            $uc = new UserCenter();
            $user = $uc->getUser($sid);
            $comment->avatar = $user['avatar'];
            $comment->name = $user['name'];

            return $comment;
        });

        return view('api.comment', ['comments' => $comments]);
    }
}
