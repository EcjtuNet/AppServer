<?php require 'header.php'; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h2 class="sub-header">设置信息</h2>
  <form action="" method="POST" enctype="multipart/form-data">
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >版本名</span>
      <input type="text" class="form-control" name="version_name" placeholder="" value="<?php echo Setting::find('version_name')->value;?>" aria-describedby="sizing-addon1">
    </div>
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >版本号</span>
      <input type="text" class="form-control" name="version_code" placeholder="" value="<?php echo Setting::find('version_code')->value;?>" aria-describedby="sizing-addon1">
    </div>
    <div class="input-group ">
      <span class="input-group-addon" id="sizing-addon1" >文件上传</span>
      <input type="file" class="form-control filestyle" data-buttonBefore="true" name="upload_file" placeholder="" aria-describedby="sizing-addon1">
    </div>
    <div class="input-group ">
      <span class="input-group-btn">
          <input class="btn btn-info" type="submit" value="保存"/>
      </span>
    </div>
  </form>
</div>
<?php require 'footer.php'; ?>