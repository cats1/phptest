<?php
//打开指定目录
function readDirctory($path){
	$handle = opendir($path);
	while(($item = readdir($handle))!==false){
		echo $item;
	    //.和..特定目录
	  if ($item != '.'&&$item != '..') {
		if (is_file($path."/".$item)) {
			$arr['file'][] = $item;
		}
		if (is_dir($path."/".$item)) {
			$arr['dir'][] = $item;
		}
	  }
    }
    closedir($handle);
    return $arr;
}
//$path = "page";
//print_r(readDirctory($path));
?>