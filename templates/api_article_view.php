<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
    <meta name="keywords" content="rcss">
    <meta name="description" content="rcss: a sample page framework">
    <meta name="author" content="zvenshy@gmail.com, creatorlanslot@gmail.com">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1><?php echo $article->title; ?></h1>
        <span class="writer">撰稿人</span>  <span class="write_at"><?php echo $article->published_at;?></span>
    </header>
    <article class="use">
    <?php echo $article->content; ?>
    </article>
    <div class="comment">
        <ul>
            <?php foreach($comments as $comment): ?>
            <li>
                <div class="avatar"><img src="http://<?php echo $comment->avatar; ?>" alt=""></div>
                <div class="content">
                    <span><?php echo $comment->name; ?></span>
                    <p><?php echo $comment->content; ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>
</body>
</html>