<?php require 'header.php'; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <form action="" method="POST">
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >标题</span>
      <input type="text" class="form-control" name="title" placeholder="" maxlength="10" value="日新网手机客户端" aria-describedby="sizing-addon1" required>
    </div>
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >内容</span>
      <input type="text" class="form-control" name="message" placeholder="" maxlength="16" aria-describedby="sizing-addon1" required>
    </div>
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >文章ID</span>
      <input type="number" class="form-control" name="aid" placeholder="" aria-describedby="sizing-addon1">
    </div>
    <div class="input-group ">
      <span class="input-group-btn">
          <input class="btn btn-info" type="submit" value="推送"/>
      </span>
    </div>
  </form>
  <h2 class="sub-header">推送信息</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>msg_id</th>
          <th>内容</th>
          <th>送达</th>
          <th>推送时间</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($pushes as $push): ?>
        <tr>
          <td><?php echo $push->id; ?></td>
          <td><?php echo $push->msg_id; ?></td>
          <td><?php echo $push->message; ?></td>
          <td><?php echo $push->received; ?></td>
          <td><?php echo $push->created_at; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</div>
<?php require 'footer.php'; ?>