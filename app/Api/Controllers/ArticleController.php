<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    public function showList()
    {
        $until = Request::get('until');
        $articles = Article::newest()->with('categories')->published();
        if ($until && $until>0) {
            $articles = $articles->until($until);
        }
        $articles = $articles->take(10)->get();
        $articles = $articles->each( function ($article) {
            unset($article['content']);
            return $article;    
        });
        $articles = $articles->toArray();
        return ['status'=>200, 'count'=>count($articles), 'articles'=>$articles];
    }

    public function show($id)
    {
        $article = Article::published()->with('Admin')->findOrFail($id);
        $arr = $article->toArray();
        $arr['status'] = 200;
        return $arr;
    }

}
