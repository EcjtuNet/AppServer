<?php
require __DIR__.'/../bootstrap.php';
use JPush\Model as M;
use JPush\JPushClient as JPush;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;
use Carbon\Carbon;
use Apfelbox\FileDownload\FileDownload;

$app->get('/init', function () use ($app) {
	$installed = Setting::find('installed');
	if(!$installed) {
		Admin::create(array('username'=>'admin', 'password'=>Admin::salt('admin', 'admin')));
		Category::create(array('id'=>1, 'text'=>'轮转图'));
		Category::create(array('id'=>2, 'text'=>'学院新闻'));
		Setting::create(array('key'=>'version_name', 'value'=>'0'));
		Setting::create(array('key'=>'version_code', 'value'=>'0'));
		Setting::create(array('key'=>'installed', 'value'=>'true'));
	}
});

$app->get('/login', function () use ($app) {
	$app->render('login.php', array(
		'failed'=>false,
		'username'=>'',
	));
});

$app->post('/login', function() use ($app, $config) {
	$username = $app->request->post('username');
	$password = $app->request->post('password');
	$remember = $app->request->post('remember');
	if(!$username || !$password)
		return $app->response->redirect('/login');
	$admin = Admin::login($username, $password);
	if(!$admin) {
		return $app->render('login.php', array(
			'failed'=>true,
			'username'=>$username
		));
	}
	$app->setcookie('admin', $username, '30 days');
	return $app->redirect('/admin');
});

$app->get('/admin', function () use ($app) {
	return $app->redirect('/admin/dashboard');
});

$app->get('/admin/dashboard', function () use ($app) {
	$logs = Log::newest()->take(10)->get();
	return $app->render('dashboard.php', array(
		'active' => 'dashboard',
		'logs' => $logs,
	));
});

$app->get('/admin/article', function () use ($app) {
	$page = $app->request->get('page') ?: 1;
	//https://laracasts.com/discuss/channels/general-discussion/laravel-5-set-current-page-programatically?page=1
	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
		return $page;
	});
	$articles = Article::orderBy('created_at', 'desc')->paginate(10)->setPath('article');
	return $app->render('article_list.php', array(
		'active' => 'article',
		'articles' => $articles,
	));
});

$app->get('/admin/article/new', function () use ($app) {
	$categories = Category::all();
	$categories = $categories->each(function($category){
		$category->checked = false;
	});
	return $app->render('article_edit.php', array(
		'id' => false,
		'active' => 'article',
		'categories' => $categories,
	));
});

$app->post('/admin/article', function () use ($app, $config) {
	$title = $app->request->post('title');
	$content = $app->request->post('content');
	$info = $app->request->post('info');
	$thumb = $app->request->post('thumb') ? 
		$app->request->post('thumb') : '/images/thumb_default.jpg';
	if(!$title || !$content || !$info || !$thumb)
		return $app->redirect('/admin/article');
	if(mb_strlen($title) > 13 || mb_strlen($info) > 40)
		return $app->redirect('/admin/article');
	$article = Article::create(array(
		'title' => $title,
		'content' => $content,
		'info' => $info,
		'thumb' => $thumb,
	));
	if(!$config['development'])
		$article->author = Admin::find($app->getCookie('admin'));
	$categories = $app->request->post('categories') ?: array();
	foreach($categories as $id => $category){
		if(Category::find($id))
			$article->addCategory(Category::find($id));
	}
	$article->save();
	return $app->redirect('/admin/article/'.$article->id);
});

$app->get('/admin/article/:id/publish', function ($id) use ($app) {
	$article = Article::find($id);
	if(!$article)
		return $app->redirect('/admin/article');
	$article->doPublish();
	return $app->redirect('/admin/article');
});

$app->get('/admin/article/:id/cancel', function ($id) use ($app) {
	$article = Article::find($id);
	if(!$article)
		return $app->redirect('/admin/article');
	$article->doCancel();
	return $app->redirect('/admin/article');
});

$app->get('/admin/article/:id', function ($id) use ($app) {
	$article = Article::find($id);
	if(!$article)
		return $app->redirect('/admin/article');
	return $app->render('article.php', array(
		'active' => 'article',
		'article' => $article
	));
});

$app->post('/admin/article/:id', function ($id) use ($app) {
	$article = Article::find($id);
	if(!$article)
		return $app->redirect('/admin/article');
	$title = $app->request->post('title');
	$content = $app->request->post('content');
	$info = $app->request->post('info');
	$thumb = $app->request->post('thumb') ? 
		$app->request->post('thumb') : '/images/thumb_default.jpg';
	if(!$title || !$content || !$info || !$thumb)
		return $app->redirect('/admin/article');
	if(mb_strlen($title) > 13 || mb_strlen($info) > 40)
		return $app->redirect('/admin/article');
	$article->title = $title;
	$article->content = $content;
	$article->info = $info;
	$article->thumb = $thumb;
	$categories = $app->request->post('categories');
	if(!$categories)
		$categories = array();
	$article->categories()->detach();
	foreach($categories as $id => $category){
		if($category && Category::find($id))
			$article->addCategory(Category::find($id));
	}
	$article->save();
	return $app->redirect('/admin/article/'.$article->id);
});

$app->get('/admin/article/:id/edit', function ($id) use ($app) {
	$article = Article::find($id);
	$categories = Category::all();
	$categories = $categories->each(function($category) use ($article) {
		$ids = $article->categories()->lists('id')->toArray();
		$category->checked = (is_array($ids)&&in_array($category->id, $ids)) ? true : false;
	});
	if(!$article)
		return $app->redirect('/admin/article');
	return $app->render('article_edit.php', array(
		'id' => $article->id,
		'active' => 'article',
		'article' => $article,
		'categories' => $categories,
	));
});

$app->get('/admin/article/:id/delete', function ($id) use ($app) {
	Article::find($id)->comments->delete();
	Article::destroy($id);
	return $app->redirect('/admin/article');
});

$app->get('/admin/comment', function () use ($app) {
	$page = $app->request->get('page') ?: 1;
	//https://laracasts.com/discuss/channels/general-discussion/laravel-5-set-current-page-programatically?page=1
	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
		return $page;
	});
	$comments = Comment::newest()->paginate(10)->setPath('comment');
	return $app->render('comment.php', array(
		'active' => 'comment',
		'comments' => $comments,
	));
});

$app->get('/admin/comment/:id/delete', function ($id) use ($app) {
	Comment::destroy($id);
	return $app->redirect('/admin/comment');
});

$app->get('/admin/push', function () use ($app, $config) {
	$page = $app->request->get('page') ?: 1;
	//https://laracasts.com/discuss/channels/general-discussion/laravel-5-set-current-page-programatically?page=1
	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
		return $page;
	});
	$pushes = Push::with('article')->orderBy('created_at', 'desc')->paginate(10)->setPath('push');
	$msg_list = $pushes->lists('msg_id');
	if($msg_list->isEmpty()) {
		return $app->render('push.php', array(
			'active' => 'push',
			'pushes' => array(),
		));
	}
	$msg_ids = implode(',', $msg_list);
	$jpush = new JPush($config['jpush']['app_key'], $config['jpush']['master_secret']);
	$result = $jpush->report($msg_ids)->received_list;
	$pushes = $pushes->each(function ($push) use ($result) {
		foreach ($result as $row) {
			if($push->msg_id == $row->msg_id && $row->android_received > $push->received) {
				$push->received = $row->android_received;
				break;
			}
		}
		$push->save();
		return $push;
	});
	return $app->render('push.php', array(
		'active' => 'push',
		'pushes' => $pushes,
	));
});

$app->post('/admin/push', function () use ($app, $config) {
	$message = $app->request->post('message');
	$title = $app->request->post('title') ? $app->request->post('title') : '日新网手机客户端';
	$aid = intval($app->request->post('aid'));
	if(!$message || !$aid)
		return $app->redirect('/admin/push');
	if(mb_strlen($title) > 10 || mb_strlen($message) > 16)
		return $app->redirect('/admin/push');
	if(!Article::find($id))
		return $app->redirect('/admin/push');
	$url = 'http://'.$config['domain'].'/api/v1/article/'.$aid.'/view';
	$jpush = new JPush($config['jpush']['app_key'], $config['jpush']['master_secret']);
	$result = $jpush->push()
	    ->setPlatform(M\all)
    	->setAudience(M\all)
		->setNotification(M\notification(M\android($message, $title, 1, array("articleId"=>$aid, "url"=>$url))))
		->send();
	$push = Push::create(array(
		'msg_id' => $result->msg_id,
		'title' => $title,
		'message' => $message,
		'article_id' => $aid,
	));
	$push->save();
	return $app->redirect('/admin/push');
});

$app->get('/admin/category', function () use ($app) {
	$page = $app->request->get('page') ?: 1;
	//https://laracasts.com/discuss/channels/general-discussion/laravel-5-set-current-page-programatically?page=1
	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
		return $page;
	});
	$categories = Category::newest()->paginate(10)->setPath('category');
	return $app->render('category.php', array(
		'active' => 'category',
		'categories' => $categories,
	));
});

$app->get('/admin/feedbacks', function () use ($app){
	$page = $app->request->get('page') ?: 1;
	//https://laracasts.com/discuss/channels/general-discussion/laravel-5-set-current-page-programatically?page=1
	Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
		return $page;
	});
	$feedbacks = Feedback::all();
	return $app->render('feedbacks.php',array(
		'active' => 'feedbacks',
		'feedbacks' => $feedbacks,
		));
});

$app->post('/admin/category/:id', function ($id) use ($app) {
	$text = $app->request->post('text');
	if(mb_strlen($text) > 6)
		return $app->redirect('/admin/category');
	$category = Category::find($id);
	if(!$text || !$category)
		return $app->redirect('/admin/category');
	$category->text = $text;
	$category->save();
	return $app->redirect('/admin/category');
});

$app->post('/admin/category', function () use ($app) {
	$text = $app->request->post('text');
	if(!$text)
		return $app->redirect('/admin/category');
	Category::create(array('text'=>$text));
	return $app->redirect('/admin/category');
});

$app->get('/admin/settings', function () use ($app) {
	$version_name = Setting::find('version_name');
	$version_name = $version_name ? $version_name->value : '';
	$version_code = Setting::find('version_code');
	$version_code = $version_code ? $version_code->value : '';
	return $app->render('settings.php', array(
		'active' => 'settings',
		'version_name' => $version_name,
		'version_code' => $version_code,
	));
});

$app->post('/admin/settings', function () use ($app) {
	if(isset($_FILES['upload_file']) && $_FILES['upload_file']['name']!='') {
		$origin_file_name = $_FILES['upload_file']['name'];
		$file = __DIR__.'/uploads/'.$origin_file_name;
		if(!stristr($origin_file_name, '.') || strtolower(end(explode('.', $origin_file_name))) != 'apk') {
			return $app->redirect('/admin/settings');
		}
		try{
			move_uploaded_file($_FILES['upload_file']['tmp_name'], $file);
		}catch(Exception $e){
			return $app->redirect('/admin/settings');
		}
		$setting = Setting::firstOrCreate(array('key'=>'apk'));
		$setting->value = $origin_file_name;
		$setting->save();
	}
	$available = ['version_code', 'version_name'];
	foreach($_POST as $key => $value) {
		if(in_array($key, $available)) {
			$row = Setting::firstOrCreate(array('key' => $key));
			$row->value = $value;
			$row->save();
		}
	}
	return $app->redirect('/admin/settings');
});

$app->post('/admin/image', function () use ($app) {
	if(!isset($_FILES['upload_file']))
		return ;
	$upload_dir = __DIR__.'/uploads/';
	$filename = strval(time()) . strval(rand(100,999)) . '.jpg';
	$file = $upload_dir . $filename;
	$origin_file_name = $_FILES['upload_file']['name'];
	if(!stristr($origin_file_name, '.') || strtolower(end(explode('.', $origin_file_name))) != 'jpg') {
		echo json_encode(array(
			'success'=> false,
			'msg'=> '请使用jpg格式图片',
		));
		return ;
	}
	try{
		move_uploaded_file($_FILES['upload_file']['tmp_name'], $file);
	}catch(Exception $e){
		echo json_encode(array(
			'success'=> false,
			'msg'=> '文件权限不足',
		));
		return ;
	}
	echo json_encode(array(
		'success'=> true,
		'file_path'=> '/uploads/' . $filename,
	));
});

$app->get('/download', function () use ($app) {
	$setting = Setting::find('apk');
	if(!$setting)
		return $app->redirect('/');
	$apk = $setting->value;
	$file = __DIR__.'/uploads/'.$apk;
	Log::record('download', $apk);
	$fd = FileDownload::createFromFilePath($file);
	$fd->sendDownload($apk);
	$app->response->headers->set('Content-Type', 'application/vnd.android.package-archive');
});

$app->get('/', function () use ($app) {
	$version_name = Setting::find('version_name');
	$dt = Carbon::parse($version_name->updated_at);
	return $app->render('index.php', array(
		'version_name' => $version_name->value,
		'published_at' => $dt->toDateString(),
	));
});

// API v1
$app->group('/api/v1', function () use ($app) {

	$app->get('/index', function () use ($app) {
		$until = intval($app->request->get('until'));
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
		if($until && $until>0)
			$normal_articles = $normal_articles->until($until);
		$normal_articles = $normal_articles->take(10)->get();
		$image_articles = $image_articles->each(function($article){
			unset($article['content']);
			return $article;
		});
		$normal_articles = $normal_articles->each(function($article){
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
		echo json_encode($return);
	});

	$app->get('/schoolnews', function () use ($app) {
		$until = intval($app->request->get('until'));
		$articles = Category::find(2)->articles()//id为2的为学院新闻
			->newest()
			->with('categories')
			->published();
		if($until && $until>0)
			$articles = $articles->until($until);
		$articles = $articles->take(10)->get();
		$articles = $articles->each(function($article){
			unset($article['content']);
			return $article;
		});
		$article = $articles->toArray();
		$return = array(
			'status' => 200,
			'count' => count($articles),
			'articles' => $articles,
		);
		echo json_encode($return);
	});

	$app->post('/feedback',function() use ($app){
	$nikename = $app->request->post('username');
	$content = $app->request->post('content');
	if (!$content) {
		echo json_encode(array(
			'status' =>false ,
			'msg'=>'请输入内容'
			 ));
		return ;
	}
	$feedback = Feedback::create(array(
		'nikename' => $nikename,
		'content' => $content
			));
	echo json_encode(array(
		'status' => 200
		));
	});

	$app->get('/articles', function () use ($app) {
		$until = intval($app->request->get('until'));
		$articles = Article::newest()->with('categories')->published();
		if($until && $until>0)
			$articles = $articles->until($until);
		$articles = $articles->take(10)->get();
		$articles = $articles->each(function($article){
			unset($article['content']);
			return $article;	
		});
		$articles = $articles->toArray();
		echo json_encode(array('status'=>200, 'count'=>count($articles), 'articles'=>$articles));
	});

	$app->get('/article/:id/view', function ($id) use ($app) {
		$article = Article::with('comments')->published()->find($id);
		$comments = $article->comments;
		if(!$article)
			return $app->response->setStatus(404);
		$article->increClick();
		$comments = $comments->each(function($comment){
			$sid = $comment->author;
			$uc = new UserCenter();
			$user = $uc->getUser($sid);
			$comment->avatar = $user['avatar'];
			$comment->name = $user['name'];
			return $comment;
		});
		$app->render('api_article_view.php', array(
			'article' => $article,
			'comments' => $comments,
		));
	});
	
	$app->post('/article/:id/comment', function ($id) use ($app) {
		$article = Article::published()->find($id);
		if(!$article){
			echo json_encode(array('status'=>404));
			return ;
		}
		$content = $app->request->post('content');
		$content = htmlspecialchars($content);
		if(str_replace(' ', '', $content) == ''){
			echo json_encode(array('status'=>400));
			return ;
		}
		$sid = $app->request->params('sid');
		$token = $app->request->params('token');
		$uc = new UserCenter();
		$user = $uc->getUser($sid,$token);
		if(!$user){
			echo json_encode(array('status'=>403));
			return ;
		}
		$comment = new Comment(array('author'=>$sid, 'content'=>$content));
		$article->comments()->save($comment);
		echo json_encode(array('status'=>200, 'content'=>$content));
	});

	$app->get('/article/:id', function ($id) use ($app) {
		$article = Article::published()->with('Admin')->find($id);
		if(!$article){
			echo json_encode(array('status'=>404));
			return ;
		}
		$arr = $article->toArray();
		$arr['status'] = 200;
		echo json_encode($arr);
	});

	$app->get('/version', function () use ($app) {
		$filename = Setting::find('apk')->value;
		$md5 = md5_file(__DIR__.'/uploads/'.$filename);
		echo json_encode(array(
			'status' => 200,
			'version_name' => Setting::find('version_name')->value,
			'version_code' => Setting::find('version_code')->value,
			'md5' => $md5,
		));
	});

});


$app->add(new AdminAuth());
$app->add(new ApiLog());
$app->run();
