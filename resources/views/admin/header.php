<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>日新网手机APP后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin">日新网手机APP管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://www.ecjtu.net">首页</a></li>
            <li><a href="http://news.ecjtu.net">新闻</a></li>
            <li><a href="http://pic.ecjtu.net">图说</a></li>
            <li><a href="#">帮助</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="搜索...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="<?php if ($active == 'dashboard') {
    echo 'active';
} ?>"><a href="/admin/dashboard">概览<?php if ($active == 'dashboard'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'article') {
    echo 'active';
} ?>"><a href="/admin/article">文章<?php if ($active == 'article'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'comment') {
    echo 'active';
} ?>"><a href="/admin/comment">评论<?php if ($active == 'comment'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'push') {
    echo 'active';
} ?>"><a href="/admin/push">推送<?php if ($active == 'push'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'category') {
    echo 'active';
} ?>"><a href="/admin/category">分类<?php if ($active == 'category'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'feedback') {
    echo 'active';
} ?>"><a href="/admin/feedback">反馈<?php if ($active == 'feedback'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
            <li class="<?php if ($active == 'setting') {
    echo 'active';
} ?>"><a href="/admin/setting">设置<?php if ($active == 'setting'): ?><span class="sr-only">(current)</span><?php endif; ?></a></li>
          </ul>
        </div>