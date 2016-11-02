<?php
/*
*name:
*description:
*author:liuyi
*time:
*/

$config = array(
	"class"=>array("version"=>"1.0000.2","updateUrl"=>"http://5461.sinaapp.com/ClassCocos2d-x.apk"),

);
$game = $_REQUEST['game'];
if(empty($config[$game])) {
	echo json_encode(array());
	exit;
}
echo json_encode($config[$game]);
exit;
?>