<?php
/*
*name:second_game.php
*description:大富翁
*author:liuyi
*time:2013-07-25 16:13:30
*/
header('Content-type: text/html; charset=utf8');
require_once('1.php');
$houseid=$_REQUEST['houseid'];//房間id
$memberid=$_REQUEST['memberid'];//成員id
$ticket=$_REQUEST['ticket'];//房間鏈接（创建）
$type=$_REQUEST['type'];//房間鏈接（创建）
if(!empty($ticket)&&$ticket=='richman') {
	
	$html=file_get_contents(VIEW_ROOT.'/second_game.html');
	$html=preg_replace('/###HOUSEID###/', $houseid, $html);
	$html=preg_replace('/###MEMBERID###/', $memberid, $html);
	echo $html;
}elseif (!empty($houseid)&&$type=="refresh"){
	if(!empty($memberid)) {
		//5秒刷新的逻辑
		exit(json_encode('00000000000'));
	}else{
		$memberid=rand(0,1);
		$html=file_get_contents(VIEW_ROOT.'/second_game.html');
		$html=preg_replace('/###HOUSEID###/', $houseid, $html);
		$html=preg_replace('/###MEMBERID###/', $memberid, $html);
		echo $html;
	}
}else{
	exit(json_encode('111111111111'));
}







?>