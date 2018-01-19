<?php 
header('Content-type:text/html; charset=UTF-8');
$con = mysql_connect('127.0.0.1', 'root', '');
if(!$con){
	die(mysql_error());
}
mysql_select_db('love', $con);
mysql_query("set names 'utf8'");
 ?>