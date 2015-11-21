<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function showList()
    {
        $comments = Comment::newest()->paginate(10);

        return view('admin.comment', [
            'active'   => 'comment',
            'comments' => $comments,
        ]);
    }

    public function delete($id)
    {
        Comment::destroy($id);

        return redirect()->route('admin_comment_list');
    }
}
