<?php require 'header.php'; ?>
  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <form action="" method="POST">
      <div class="input-group ">
        <span class="input-group-addon" id="sizing-addon1" >添加分类</span>
        <input type="text" class="form-control" name="text" placeholder="分类名" maxlength="6" value="" aria-describedby="sizing-addon1" required>
        <span class="input-group-btn">
          <input class="btn btn-info" type="submit" value="添加"/>
        </span>
      </div>
      
    </form>
  <h2 class="sub-header">分类信息</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>分类</th>
          <th>文章数量</th>
          <th>添加时间</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
          <td><?php echo $category->id; ?></td>
          <td><?php echo $category->text; ?></td>
          <td><?php echo $category->articles->count(); ?></td>
          <td><?php echo $category->created_at; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  </div>
<?php require 'footer.php'; ?>