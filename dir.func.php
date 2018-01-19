<?php
//打开指定目录
function readDirctory($path){
	$file = scandir($path);
	foreach ($file as $item) {
		if ($item != '.'&&$item != '..') {
		if (is_file($path."/".$item)) {
			$arr['file'][] = $item;
		}
		if (is_dir($path."/".$item)) {
			$arr['dir'][] = $item;
		}
	  }
	}
    return $arr;
}
?>