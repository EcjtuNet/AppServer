<?php require 'header.php'; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <a href="/admin/article/new" class="btn btn-info">新建文章</a>
  <h2 class="sub-header">文章信息</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>标题</th>
          <th>阅读量</th>
          <th>发布时间</th>
          <th>发布</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($articles as $article): ?>
        <tr>
          <td><?php echo $article->id; ?></td>
          <td><a href="/admin/article/<?php echo $article->id; ?>"><?php echo $article->title; ?></a></td>
          <td><?php echo $article->click; ?></td>
          <td><?php echo $article->published_at; ?></td>
          <?php if(!$article->published): ?>
          <td><a class="btn btn-info btn-xs" href="/admin/article/<?php echo $article->id; ?>/publish">发布</a></td>
          <?php else: ?>
          <td><a class="btn btn-warning btn-xs" href="/admin/article/<?php echo $article->id; ?>/cancel">取消发布</a></td>
          <?php endif; ?>
          <td><a class="btn btn-warning btn-xs" href="/admin/article/<?php echo $article->id; ?>/delete">删除</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php echo $articles->render(); ?>
</div>
<?php require 'footer.php'; ?>