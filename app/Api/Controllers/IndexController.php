<?php

namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use Dingo\Api\Http\Request;
use App\Category;
use App\Article;

class IndexController extends Controller
{
    /**
     * @api {get} /index 首页
     * @apiVersion 1.0.0
     * @apiName GetIndex
     * @apiGroup Index
     * 
     * @apiSuccess {Number} status 状态码
     * @apiSuccess {Object} slide_article 轮转图文章
     * @apiSuccess {Number} slide_article.count 轮转图文章数量
     * @apiSuccess {Object[]} slide_article.articles 轮转图文章列表
     * @apiSuccess {Object} normal_article 普通文章
     * @apiSuccess {Number} normal_article.count 普通文章数量
     * @apiSuccess {Object[]} normal_article.articles 普通文章列表
     */
    public function showIndex(Request $request)
    {
        $until = intval($request->get('until'));
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

    /**
     * @api {get} /schoolnews 学院新闻
     * @apiVersion 1.0.0
     * @apiName GetSchoolnews
     * @apiGroup Index
     *
     * @apiSuccess {Number} status 状态码
     * @apiSuccess {Number} count 学院新闻数量
     * @apiSuccess {Object[]} articles 学院新闻列表
     */
    public function showSchoolnews(Request $request)
    {
        $until = intval($request->get('until'));
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
