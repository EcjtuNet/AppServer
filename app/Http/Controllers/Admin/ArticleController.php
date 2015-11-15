<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\Category;
use App\Comment;

class ArticleController extends Controller
{
    public function showList()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.article_list', [
            'active' => 'article',
            'articles' => $articles,
        ]);
    }

    public function showNew()
    {
        $categories = Category::all();
        $categories = $categories->each(function($category){
            $category->checked = false;
        });
        return view('admin.article_edit', [
            'id' => false,
            'active' => 'article',
            'categories' => $categories,
        ]);
    }

    public function submit(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $info = $request->input('info');
        $thumb = $request->input('thumb') ?: '/images/thumb_default.jpg';
        if (!$title || !$content || !$info || !$thumb) {
            return redirect()->route('admin_article_list');
        }
        if( mb_strlen($title) > 13 || mb_strlen($info) > 40) {
            return redirect()->route('admin_article_list');
        }
        $article = Article::create([
            'title' => $title,
            'content' => $content,
            'info' => $info,
            'thumb' => $thumb,
        ]);
        $categories = $request->input('categories') ?: [];
        foreach ($categories as $id => $category) {
            if (Category::find($id)) {
                $article->addCategory(Category::find($id));
            }
        }
        $article->save();
        return redirect()->route('admin_show_article', ['id' => $article->id]);
    }

    public function edit(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('admin_article_list');
        }
        $title = $request->input('title');
        $content = $request->input('content');
        $info = $request->input('info');
        $thumb = $request->input('thumb') ?: '/images/thumb_default.jpg';
        if (!$title || !$content || !$info || !$thumb) {
            return redirect()->route('admin_article_list');
        }
        if( mb_strlen($title) > 13 || mb_strlen($info) > 40) {
            return redirect()->route('admin_article_list');
        }
        $article->title = $title;
        $article->content = $content;
        $article->info = $info;
        $article->thumb = $thumb;
        $categories = $request->input('categories') ?: [];
        $article->categories()->detach();
        foreach($categories as $id => $category){
            if($category && Category::find($id))
                $article->addCategory(Category::find($id));
        }
        $article->save();
        return redirect()->route('admin_show_article', ['id' => $article->id]);        
    }

    public function publish(Request $request, $id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->doPublish();
        }
        return redirect()->route('admin_article_list');
    }

    public function cancel(Request $request, $id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->doCancel();
        }
        return redirect()->route('admin_article_list');
    }

    public function show($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('admin_article_list');
        }
        return view('admin.article', [
            'active' => 'article',
            'article' => $article,
        ]);
    }

    public function showEdit(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            return redirect()->route('admin_article_list');
        }
        $categories = Category::all();
        $categories = $categories->each(function($category) use ($article) {
            $ids = $article->categories()->lists('id')->toArray();
            $category->checked = (is_array($ids)&&in_array($category->id, $ids)) ? true : false;
        });
        return view('admin.article_edit', [
            'id' => $article->id,
            'active' => 'article',
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public  function delete($id)
    {
        $comments = Comment::where('commentable_id', '=', $id);
        if ($comments) {
            $comments->delete(); 
        }
        Article::destroy($id);
        return redirect()->route('admin_article_list');
    }
}
