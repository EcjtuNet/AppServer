<?php require 'header.php'; ?>
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  	<a href="/admin/article/<?php echo $article->id; ?>/edit" class="btn btn-info">编辑文章</a>
  	<div class="panel panel-default">
  	  <div class="panel-heading">
        <h3 class="panel-title"><?php echo $article->title; ?></h3>
      </div>
      <div class="panel-body">
      	<article>
          <?php echo $article->content; ?>
      	</article>
      </div>
    </div>
  </div>
<?php require 'footer.php'; ?>