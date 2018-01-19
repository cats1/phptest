<?php
require_once "dir.func.php";
require_once "file.func.php";
require_once "common.func.php";
$path = "page";
$path = $_REQUEST['path']?$_REQUEST['path']:$path;
$act=$_REQUEST['act'];
$filename=$_REQUEST['filename'];
$info = readDirctory($path);
$redirect = "index.php?path={$path}";
//print_r($info);
if($act == "createFile"){
  /*echo $path,"--";
  echo $filename;*/
  $mes = createFile($path."/".$filename);
  alertMes($mes,$redirect);
} else if($act == "showContent") {
  $content = file_get_contents($filename);
  if (strlen($content)) {
  	$newContent = highlight_string($content, true);
	echo $newContent;
	  //highlight_string($content);
	  //highlight_file($filename);
  } else {
  	alertMes('文件内容为空',$redirect);
  }
  
} else if($act == "editContent"){
	$content = file_get_contents($filename);
	$str = <<<EOF
	<form action='index.php?act=doEdit' method='post'>
      <textarea name="content" cols='190' rows='10'>{$content}</textarea><br/>
      <input type="hidden" name="filename" value="{$filename}"/>
      <input type="submit" value="修改文件内容"/>
	</form>
EOF;
   echo $str;
} else if ($act == 'doEdit') {
  $content = $_REQUEST['content'];
  //echo $content;
  if (file_put_contents($filename,$content)) {
  	$mes = "success";
  } else {
  	$mes = "error";
  }
  alertMes($mes,$redirect);
} else if ($act == 'renameFile') {
  $str = <<<EOF
  <form action='index.php?act=dorRename' method='post'>
  请填写新文件名<input type="text" name="newname" />
  <input type="hidden" name="filename" value="{$filename}"/>
      <input type="submit" value="重命名"/>
	</form>
EOF;
echo $str;
} else if ($act == 'dorRename') {
  $newname = $_REQUEST['newname'];
  $mes = renameFile($filename,$newname);
  alertMes($mes,$redirect);
} else if ($act == 'delFile') {
  $mes = delFile($filename);
  alertMes($mes,$redirect);
} else if ($act == 'downFile') {
  $mes = downFile($filename);
  alertMes($mes,$redirect);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>php</title>
	<script>
		function show(dis){
			document.getElementById(dis).style.display = "block"
		}
		function delFile(filename){
			alert(filename);
			if (window.confirm("确定删除？")) {
              location.href="index.php?act=delFile&filename="+ filename;
			}
		}
	</script>
</head>
<body>
<ul>
	<li><a href="index.php"><span>主页</span></a></li>
	<li><a href="#" onclick="show('createFile')"><span>创建文件</span></a></li>
	<li><a href="#"><span>创建文件夹</span></a></li>
	<li><a href="#"><span>上传文件</span></a></li>
	<li><a href="#"><span>返回上级目录</span></a></li>
</ul>
<form action="index.php" method="post">
<table border="1" width="100%" cellpadding="0" cellspacing="0">
	<tr id="createFolder" style="display: none;">
		<td>输入文件夹名</td>
		<td>
			<input type="text" name="dirname">
			<input type="submit" value="创建文件夹">
		</td>	
	</tr>
	<tr id="createFile" style="display: none;">
		<td>输入文件名</td>
		<td>
			<input type="text" name="filename">
			<input type="hidden" name="path" value="<?php echo $path;?>">
			<input type="hidden" name="act" value="createFile">
			<input type="submit" value="创建文件">
		</td>	
	</tr>
	<tr id="uploadFile" style="display: none;">
		<td>选择要上传的文件</td>
		<td>
			<input type="file" name="myFile">
			<input type="submit" name="act" value="上传文件">
		</td>	
	</tr>
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
    	<td><?php echo filetype($p) == "file" ? "file_ico.png":"folder_ico.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php echo transByte(filesize($p)); ?></td>
    	<td><?php $src = is_readable($p)? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php $src = is_writable($p) ? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php $src = is_executable($p) ? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php echo filectime($p);?></td>
    	<td><?php echo filectime($p);?></td>
    	<td><?php echo filectime($p);?></td>
    	<?php
    	  $ext = strtolower(end(explode(".", $val)));
    	  $imgageExt = array("gif","jpg","jpeg","png");
    	  if (in_array($ext, $imgageExt)) {
    	?>
    	<!-- <a href="#" onclick=""><img src="page/d18.png" alt=""></a> -->
    	<?php
    	  	 
    	  } else {}

    	?>
    	<td>
    		<a href="index.php?act=showContent&filename=<?php echo $p;?>">查看</a>
    		<a href="index.php?act=editContent&filename=<?php echo $p;?>">修改</a>
    		<a href="index.php?act=renameFile&filename=<?php echo $p;?>">重命名</a>
    		<a href="#" onclick="delFile('<?php echo $p;?>')">删除</a>
    		<a href="index.php?act=downFile&filename=<?php echo $p;?>">下载</a>
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
    	<td><?php echo filetype($p) == "file" ? "file_ico.png":"folder_ico.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php echo dirSize($p); ?></td>
    	<td><?php $src = is_readable($p)? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php $src = is_writable($p) ? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php $src = is_executable($p) ? "correct.png":"error.png"; ?><img src="<?php echo $src; ?>" alt="" /></td>
    	<td><?php echo filectime($p);?></td>
    	<td><?php echo filectime($p);?></td>
    	<td><?php echo filectime($p);?></td>
    	<td>
    		<a href="index.php?path=<?php echo $p;?>">查看</a>
    		<a href="index.php?act=renameFile&filename=<?php echo $p;?>">重命名</a>
    		<a href="#" onclick="delFile('<?php echo $p;?>')">删除</a>
    		<a href="index.php?act=downFile&filename=<?php echo $p;?>">下载</a>
    	</td>
    	
    </tr>
    <?php
    $i++;
    }	
    }
    ?>
</table>
</form>
</body>
</html>