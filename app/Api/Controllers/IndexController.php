<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use App\Category;
use App\Article;

class IndexController extends Controller
{
    public function showIndex()
    {
        $until = intval(Request::get('until'));
        //分类ID为1的作为首页轮转图
        $image_articles = Category::find(1)->articles()
            ->newest()
            ->with('categories')
            ->published()
            ->take(3)
            ->get();
        $normal_articles = Article::whereNotIn('id', $image_articles->lists('id'))
            ->whereDoesntHave('categories')
            ->newest()
            ->with('categories')
            ->published();
        if ($until && $until>0) {
            $normal_articles = $normal_articles->until($until);
        }
        $normal_articles = $normal_articles->take(10)->get();
        $image_articles = $image_articles->each( function ($article) {
            unset($article['content']);
            return $article;
        });
        $normal_articles = $normal_articles->each( function ($article) {
            unset($article['content']);
            return $article;    
        });
        $image_articles = $image_articles->toArray();
        $normal_articles = $normal_articles->toArray();
        $return = array(
            'status' => 200,
            'slide_article' => array(
                'count' => count($image_articles),
                'articles' => $image_articles,
            ), 
            'normal_article' => array(
                'count' => count($normal_articles),
                'articles' => $normal_articles,
            ),
        );
        return $return;
    }

    public function showSchoolnews()
    {
        $until = intval(Request::get('until'));
        //id为2的为学院新闻
        $articles = Category::find(2)->articles()
            ->newest()
            ->with('categories')
            ->published();
        if ($until && $until>0) {
            $articles = $articles->until($until);
        }
        $articles = $articles->take(10)->get();
        $articles = $articles->each( function ($article) {
            unset($article['content']);
            return $article;
        });
        $article = $articles->toArray();
        $return = array(
            'status' => 200,
            'count' => count($articles),
            'articles' => $articles,
        );
        return $return;
    }
}
