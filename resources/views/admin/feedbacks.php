<?php require 'header.php'; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h2 class="sub-header">意见反馈</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>姓名</th>
          <th>内容</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach($feedbacks as $feedback): ?>
        <tr>
          <td><?php echo $feedback->id; ?></td>
          <td><?php echo $feedback->nikename; ?></td>
          <td><?php echo $feedback->content; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php echo $feedbacks->render(); ?>
</div>
<?php require 'footer.php'; ?>