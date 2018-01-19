<?php 
  $action = $_GET['action'];
  $filename = $_GET['filename'];
  if ($action == "checkFile") {
  	$content = file_get_contents($filename);
	if (strlen($content)) {
	  $newContent = highlight_string($content, true);
	  echo $newContent;
	} else {
	  //alertMes('文件内容为空',$redirect);
	}
  } else if ($action == "updateFile") {
  	$content = file_get_contents($filename);
	if (strlen($content)) {
	  $newContent = highlight_string($content, true);
	  echo $newContent;
	} else {
	  //alertMes('文件内容为空',$redirect);
	}
  } else if ($action == "checkFolder") {
  	$content = file_get_contents($filename);
	if (strlen($content)) {
	  $newContent = highlight_string($content, true);
	  echo $newContent;
	} else {
	  //alertMes('文件内容为空',$redirect);
	}
  }
 ?>