<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuyi
 * Date: 14/12/22
 * Time: 下午5:25
 */

//path 路径
define( 'PATH_ROOT', dirname(__FILE__).'/' );			// 根目录
define( 'PATH_CONTROL', PATH_ROOT.'Control/');			// 命令(逻辑)目录
define( 'PATH_MODEL', PATH_ROOT.'Model/');			// 数据对象目录
define( 'PATH_CACHE', PATH_ROOT.'Model/Cache/');			// 数据对象目录
define( 'PATH_VIEW', PATH_ROOT.'View/');			// 配置文件目录
define( 'PATH_IMAGE', PATH_ROOT.'Image/');			// 配置文件目录


//mysql 配置
define('MYSQL_HOST','10.1.7.250');
define('MYSQL_PORT','3306');
define('MYSQL_USER','root');
define('MYSQL_PASS','');
define('MYSQL_DBNAME','test');

//redis 配置

define('REDIS_HOST','10.1.7.250');
define('REDIS_PORT','6379');
define('REDIS_TIMEOUT','30');

//图片后缀
define('IMAGE_SUFFIX','png');
