<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>日新评论</title>
    <link rel="stylesheet" href="/css/review.css"/>
    <link rel="stylesheet" href="/css/materialize.min.css">
    <style>
        @font-face {
          font-family: 'Material Icons';
          font-style: normal;
          font-weight: 400;
          src: local('Material Icons'), local('MaterialIcons-Regular'), url(./font/material-design-icons/Material-Design-Icons.woff), url(https://fonts.gstatic.com/s/materialicons/v8/2fcrYFNaTjcS6g4U3t-Y5RV6cRhDpPC5P4GCEJpqGoc.woff) format('woff');
        }
        .material-icons {
          font-family: 'Material Icons';
          font-weight: normal;
          font-style: normal;
          font-size: 24px;
          line-height: 1;
          letter-spacing: normal;
          text-transform: none;
          display: inline-block;
          white-space: nowrap;
          word-wrap: normal;
          direction: ltr;
          text-rendering: optimizeLegibility;
          -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body>
    <div class="row">
        <?php foreach ($comments as $comment ) : ?>
        <div class="review-card s12 waves-effect light-waves">
            <h6 class="review-title">
                <span class="user-avatar"><img src="http://<?php echo $comment->avatar; ?>" alt="头像"></span>
                <span class="user-name"><?php echo $comment->name; ?></span>
                <span class="publish-time"><?php echo $comment->create_at ?></span>
            </h6>
            <p class="user-review"><?php  echo $comment->content;?></p>
        </div>
    <?php endforeach ?>
        <h6 class="review-tips">OuO 没有更多数据了呐</h6>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/review.js"></script>
</body>
</html>
