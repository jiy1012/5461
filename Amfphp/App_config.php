<?php
define( 'PATH_ROOT', dirname(__FILE__).'/' );			// 根目录
define( 'PATH_CMD', PATH_ROOT.'cmd/');			// 命令(逻辑)目录
define( 'PATH_OBJ', PATH_ROOT.'obj/');			// 数据对象目录
define( 'PATH_CACHE', PATH_ROOT.'obj/cache/');      // mc层
if (file_exists(PATH_ROOT . 'framework/')) {
    define( 'FRAMEWORK', PATH_ROOT . 'framework/');         //主框架目录
}else{
    define( 'FRAMEWORK', PATH_ROOT . '../framework/');         //主框架目录
}

if(PHP_OS == "WINNT" || PHP_OS == 'Darwin'){
    include PATH_ROOT . 'local.php';
    define ( 'SERVER_NO', 0);
}
else{
    include PATH_ROOT . 'online.php';
    define ( 'SERVER_NO', 1);
}




?>