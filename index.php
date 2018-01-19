<?php
ini_set('date.timezone','Asia/Shanghai');
require_once "dir.func.php";
require_once "file.func.php";
require_once "common.func.php";
$path = dirname(dirname(__FILE__));//取得当前文件的上一层目录名，结果：/Users/lana/lft 
$path = $_REQUEST['path']?$_REQUEST['path']:$path;
/*$act=$_REQUEST['act'];
$filename=$_REQUEST['filename'];*/
$info = readDirctory($path);
$redirect = "index.php?path={$path}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>在线编辑页面</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<form action="index.php" method="post">
	<table class="table table-striped">
		<tr>
		<td>编号</td>
		<td>名称</td>
		<td>类型</td>
		<td>大小</td>
		<td>可读</td>
		<td>可写</td>
		<td>可执行</td>
		<td>创建时间</td>
		<td>修改时间</td>
		<td>访问时间</td>
		<td>操作</td>
	</tr>
		<?php
    if ($info['file']) {
    	$i = 1;
    	foreach($info['file'] as $val){
    		$p = $path."/".$val
    ?>
    <tr>
    <td><?php echo $i; ?></td>
    	<td><?php echo $val; ?></td>
    	<td><div class="fileicon"><i class="fa fa-file"></i></div></td>
    	<td><?php echo transByte(filesize($p)); ?></td>
    	<td><?php $src = is_readable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php $src = is_writable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php $src = is_executable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php echo date("Y.m.d H:i:s",filectime($p));?></td>
    	<td><?php echo date("Y.m.d H:i:s",filemtime($p));?></td>
    	<td><?php echo date("Y.m.d H:i:s",fileatime($p));?></td>
    	<td>
    		<a href="#" title="查看" class="checkicon checkmess" onclick="showFileMessage('<?php echo $p?>')"><i class="fa fa-eye"></i></a>
    		<a href="#" title="修改" class="checkicon" onclick="updateFileMessage('<?php echo $p?>')"><i class="fa fa-edit"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="重命名" class="checkicon"><i class="fa fa-cog"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="删除" class="checkicon"><i class="fa fa-trash-o"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="下载" class="checkicon"><i class="fa fa-cloud-download"></i></a>
    	</td>
    </tr>
    <?php
    $i++;
    }	
    }
    ?>
    <?php
    if ($info['dir']) {
    	foreach($info['dir'] as $val){
    		$p = $path."/".$val
    ?>
    <tr>
    	<td><?php echo $i; ?></td>
    	<td><?php echo $val; ?></td>
    	<td><div class="foldericon"><i class="fa fa-folder"></i></div></td>
    	<td><?php echo transByte($p); ?></td>
    	<td><?php $src = is_readable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php $src = is_writable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php $src = is_executable($p)? "fa-check":"fa-close"; ?><div class="checkicon check<?php echo $src; ?>"><i class="fa <?php echo $src; ?>"></i></div></td>
    	<td><?php echo date("Y.m.d H:i:s",filectime($p));?></td>
    	<td><?php echo date("Y.m.d H:i:s",filemtime($p));?></td>
    	<td><?php echo date("Y.m.d H:i:s",fileatime($p));?></td>
    	<td>
    		<a href="index.php?path=<?php echo $p;?>" title="查看" class="checkicon checkmess"><i class="fa fa-eye"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="修改" class="checkicon"><i class="fa fa-edit"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="重命名" class="checkicon"><i class="fa fa-cog"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="删除" class="checkicon"><i class="fa fa-trash-o"></i></a>
    		<a href="index.php?act=&filename=<?php echo $p;?>" title="下载" class="checkicon" ><i class="fa fa-cloud-download"></i></a>
    	</td>
    </tr>
    <?php
    $i++;
    }	
    }
    ?>
	</ul>

</form>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="showmessmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">展示</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="word-break: break-all;">
        <div class="showmess" id="modalshowbody"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary">保存</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="js/lib/jquery-3.2.1.min.js"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/index.js"></script>
</body>
</html>