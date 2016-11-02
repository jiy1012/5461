<?php
/*
*name:testmysql.php
*description:测试mysql
*author:liuyi
*time:2012/12/5 18:56
*/
header('Content-type: text/html; charset=utf8');
require_once('config.inc.php');

$now=time();
$ip=$_SERVER['REMOTE_ADDR'];
$sql="insert into `first_game` (`pic_name`,`link_url`,`upload_time`,`upload_ip`) values ('2.jpg','201212051921',$now,'"."$ip"."')";
// $mysql->runSql( $sql );
if( $mysql->errno() != 0 )
{
    exit( "Error:" . $mysql->errmsg() );
}else{
    echo "插入成功！";
}
if (!is_dir('Picture')){
	mkdir('Picture',0777);
}else{
	echo"已经存在!"; 
}


?>
