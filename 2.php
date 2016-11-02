<?php
/*
*name:
*description:
*author:liuyi
*time:
*/
header('Content-type: text/html; charset=utf8');
error_reporting(E_ALL);
set_time_limit(0);
require_once('1.php');
// if(extension_loaded('mongo')) {
// echo "1111111";
// }else{
// echo "2222222";
// }
// $a=get_loaded_extensions();
// print_r($a);
// $mongodb->connectDb();
print_r($mongodb->getAllDbs());
// $mongodb->dropOneDb('liuyi_mongo');
$mongodb->createOneDb('nousertest');
// var_dump($mongodb->mongoDb);
// $mongodb->mongoDb->createCollection('liuyi_mongo');
//$res=$mysql->getRow('user_account');
//echo '<pre>';
//print_r($res);
//echo '</pre>';

//$res1=$mysql->insertValues('user_account','0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
//var_dump($res1);
// $fieldvalue=array('uid'=>999999930,'farmname'=>'liuyi','level'=>10);
// $condition=array('farmuid'=>999999929);
// $mysql->updateTableValue('user_account',$fieldvalue,$condition);
// for($i=0;$i<=366;$i++){
// 	$sql="DROP TABLE IF EXISTS `user_action_log_$i`";
// 	$mysql->querySql($sql);
// 	$sql="CREATE TABLE `user_action_log_$i` (
// 	  `farmuid` int(10) unsigned NOT NULL,
// 	  `action_type` tinyint(3) unsigned NOT NULL default '0',
// 	  `coin` int(11) NOT NULL default '0',
// 	  `money` int(11) NOT NULL default '0',
// 	  `experience` int(11) NOT NULL default '0',
// 	  `charm` int(11) NOT NULL default '0',
// 	  `content` varchar(1024) NOT NULL default '',
// 	  `create_time` int(10) unsigned NOT NULL,
// 	  KEY `idx_farmuid` (`farmuid`)
// 	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// 	// echo "$sql";
// 	$mysql->querySql($sql);
// 	echo $mysql->errno().$mysql->error();
// }
// echo "complete";
// echo "------";
//mysql_connect("localhost:3306", "root", "") or
//    die("Could not connect: " . mysql_error());
//mysql_select_db("snsfarm");
//
//$result = mysql_query("SHOW COLUMNS FROM user_account");
//$arr=array();
//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
//	$arr[]=$row;
//}
//echo '<pre>';
//print_r($arr);
//echo '</pre>';

//mysql_free_result($result);
?>