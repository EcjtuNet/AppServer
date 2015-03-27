<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="/simditor/styles/simditor.css" />
<script type="text/javascript" src="/simditor/scripts/jquery.min.js"></script>
<script type="text/javascript" src="/simditor/scripts/module.js"></script>
<script type="text/javascript" src="/simditor/scripts/hotkeys.js"></script>
<script type="text/javascript" src="/simditor/scripts/uploader.js"></script>
<script type="text/javascript" src="/simditor/scripts/simditor.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <form action="<?php echo $id ? '/admin/article/'.$id : '/admin/article';?>" method="POST">
  <div class="input-group ">
    <span class="input-group-addon" id="sizing-addon1" >标题</span>
    <input type="text" class="form-control" name="title" placeholder="" value="<?php echo $id ? $article->title : ''; ?>" aria-describedby="sizing-addon1">
  </div>
  <textarea id="editor" name="content" placeholder="这里输入内容" autofocus><?php echo $id ? $article->content : ''; ?></textarea>
  <input class="btn btn-info" type="submit" value="提交">
  </form>
</div>
<script>
var editor = new Simditor({
  textarea: $('#editor')
});
</script>
<?php require 'footer.php'; ?>