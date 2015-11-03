<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>日新评论</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/scss/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
</head>
<body>
    <div class="row">
        <?php foreach ($comments as $comment ) : ?>
        <div class="review-card s12 waves-effect light-waves">
            <h6 class="review-title">
                <span class="user-avatar"></span>
                <span class="user-name"><?php echo $comment->name; ?></span>
                <span class="publish-time"><?php echo $comment->create_at ?></span>
            </h6>
            <p class="user-review"><?php  echo $comment->content;?></p>
        </div>
        <h6 class="review-tips">OuO 没有更多数据了呐</h6>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="/js/review.js"></script>
</body>
</html>
