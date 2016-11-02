<?php
/*
*name:config.inc.php
*description:配置文件
*author:liuyi
*time:2012/12/5 18:56
*/

session_start();

define('WEB_ROOT',realpath(dirname(__FILE__)));
define('MODEL_ROOT',WEB_ROOT.'/Model');
define('PICTURE_ROOT',WEB_ROOT.'/Picture');
define('VIEW_ROOT',WEB_ROOT.'/View');
require_once(MODEL_ROOT.'/Mysql.class.php');
$mysql = new Mysql();
$fetchurl=new SaeFetchurl();
$image = new SaeImage();
$mysql->setCharset('UTF8');
















?>