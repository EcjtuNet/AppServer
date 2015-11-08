<?php require 'header.php'; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h2 class="sub-header">评论管理</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>学号</th>
          <th>内容</th>
          <th>文章ID</th>
          <th>文章标题</th>
          <th>删除</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($comments as $comment): ?>
        <tr>
          <td><?php echo $comment->id; ?></td>
          <td><?php echo $comment->author; ?></td>
          <td><?php echo $comment->content; ?></td>
          <td><?php echo $comment->commentable->id; ?></td>
          <td><?php echo $comment->commentable->title; ?></td>
          <td><a class="btn btn-warning btn-xs" href="/admin/comment/<?php echo $comment->id; ?>/delete">删除</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php echo $comments->render(); ?>
</div>
<?php require 'footer.php'; ?>