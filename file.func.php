<?php
//$size = 12445;
//Byte/Kb/MB/GB/TB/EB
//
function transByte($size){
	$arr = array("B","KB","MB","GB","TB","EB");
	$i = 0;
	while($size>1024){
		$size/=1024;
		$i++;
	}
	return round($size,2).$arr[$i];
}
// echo round($size,2).$arr[$i];
function createFile($filename){
  //合法性/,*,<>,?,|
  $pattern = "/[\/,\*,<>,\?\|]/";
  if (!preg_match($pattern,basename($filename))) {
  	if (!file_exists($filename)) {
  		if(touch($filename)){
  			return "文件创建成功";
  		} else {
  			return "文件创建失败";
  		}
  	} else{
  		return "文件已存在，请重命名后创建";
  	}
  } else {
  	return "非法文件名";
  }
}
function renameFile($oldname,$newname){
  if (checkFilename($newname)) {
  	$path = dirname($oldname);
  	if (!file_exists($path."/".$newname)) {
  		if (rename($oldname, $path."/".$newname)) {
  			return "成功";
  		} else {
  			return "失败";
  		}
  	} else {
  		return "存在同名文件";
  	}
  } else {
  	return "非法文件名";
  }
}
function checkFilename($filename){
	$pattern = "/[\/,\*,<>,\?\|]/";
  if (preg_match($pattern,basename($filename))) {
  	return false;
  } else {
  	return true;
  }
}
function delFile($filename){
	if (file_exists($filename)) {
		if (unlink($filename)) {
		    $mes = '删除成功';
		} else {
			$mes = '删除失败';
		}
	} else {
       $mes = '文件不存在';
	}
	
	return $mes;
}
function downFile($filename){
	header("content-disposition:attachment;filename=".basename($filename));
	header("content-length:".filesize($filename));
	readerfile($filename);
}
function dirSize($dir){
	$sum = 0;
	$handler = opendir($dir);
	while(($item = readdir($handler)) !== false){
		if ($item!= "."&&$item!= "..") {
			if (is_file($dir."/".$item)) {
		     	$sum += filesize($dir."/".$item);
		     }
		     if (is_dir($dir."/".$item)) {
		     	$func = __FUNCTION__;
		     	$func($dir."/".$item);
		     }
		}     
	}
	closedir($handler);
	return transByte($sum);
}
?>