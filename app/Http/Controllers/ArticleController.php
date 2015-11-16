<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function showView($id)
    {
        $article = Article::with('comments')->published()->findOrFail($id);
        $article->increClick();
        return view('api.article', ['article' => $article]);
    }
}
