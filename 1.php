<?php
/*
*name:
*description:
*author:liuyi
*time:
*/

session_start();
set_time_limit(0);
define('WEB_ROOT',realpath(dirname(__FILE__)));
define('MODEL_ROOT',WEB_ROOT.'/Model');
define('PICTURE_ROOT',WEB_ROOT.'/Picture');
define('VIEW_ROOT',WEB_ROOT.'/View');
require_once(MODEL_ROOT.'/MysqlDb.class.php');
require_once(MODEL_ROOT.'/MongoDbHelper.class.php');
$db_w=array('localhost',3306,'root','','app_5461');
$db_r=array('localhost',3306,'root','','app_5461');


?>