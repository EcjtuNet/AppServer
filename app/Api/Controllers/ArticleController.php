<?php

namespace App\Api\Controllers;

use Dingo\Api\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    /**
     * @api {get} /articles 获取文章列表
     * @apiVersion 1.0.0
     * @apiName GetArticleList
     * @apiGroup Article
     *
     * @apiSuccess {Number} status 状态码
     * @apiSuccess {Number} count 文章的数量
     * @apiSuccess {Object[]} articles 文章列表
     */
    public function showList(Request $request)
    {
        $until = $request->get('until');
        $articles = Article::newest()->with('categories')->published();
        if ($until && $until > 0) {
            $articles = $articles->until($until);
        }
        $articles = $articles->take(10)->get();
        $articles = $articles->each(function ($article) {
            unset($article['content']);

            return $article;
        });
        $articles = $articles->toArray();

        return ['status' => 200, 'count' => count($articles), 'articles' => $articles];
    }

    /**
     * @api {get} /article/:id 获取文章信息
     * @apiVersion 1.0.0
     * @apiName GetArticle
     * @apiGroup Article
     * 
     * @apiParam {Number} id 文章ID
     *
     * @apiSuccess {Number} status 状态码
     * @apiSuccess {Number} id 文章ID
     * @apiSuccess {String} title 文章标题
     * @apiSuccess {String} info 文章描述
     * @apiSuccess {Number} click 点击数
     * @apiSuccess {Boolean} published 文章是否发布
     * @apiSuccess {Date} published_at 发布时间
     * @apiSuccess {String} thumb 文章缩略图地址
     * @apiSuccess {Date} deleted_at 文章删除时间
     * @apiSuccess {Date} created_at 文章创建时间
     * @apiSuccess {Date} updated_at 文章更新时间
     * @apiSuccess {String} content 文章内容
     */
    public function show($id)
    {
        $article = Article::published()->with('Admin')->findOrFail($id);
        $arr = $article->toArray();
        $arr['status'] = 200;

        return $arr;
    }
}
