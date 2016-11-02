<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuyi
 * Date: 14/12/22
 * Time: 下午5:21
 */
require_once './config.inc.php';

require_once PATH_CONTROL.'UserControl.php';
require_once PATH_CONTROL.'ViewControl.php';
$userMC = new UserControl();
$viewMC = new ViewControl();

//@todo 所有用户的输入都必须加验证 是不是空验证，类型格式验证

$act = trim($_REQUEST['act']);

if('listall' == $act){
    //展示列表
    //http://10.1.7.250/moji/index.php?act=listall&start=2&end=4
    //start：要取得的开始的图片id（默认为空） end：要取得的结束的图片id limit：取多少张 order排序方式
    $startId = intval($_REQUEST['start']);
    $endId = intval($_REQUEST['end']);
    $limit = intval($_REQUEST['limit']) > 0 ?intval($_REQUEST['limit']):50;
    $order = 'DESC';

    $list = $userMC->getAllListByLimit($startId,$endId,$limit,$order);
    return $list;
}elseif('vote' == $act){
    //投票
    //http://10.1.7.250/moji/index.php?act=vote&imageId=6
    $imageId = intval($_REQUEST['imageId']);
    $userMC->addVoteByImageId($imageId);
    return true;
}elseif('upload' == $act){
    //点击上传按钮
/*
 *
 * $_REQUEST ＝ Array
(
    [act] => upload
    [user_name] => 111
    [tel] => 22222
    [op] => upload
)
$_FILES ＝ Array
(
    [image] => Array
        (
            [name] => backimg.png
            [type] => image/png
            [tmp_name] => D:\wamp\tmp\phpE8A6.tmp
            [error] => 0
            [size] => 833355
        )

)
*/
    //@todo 这里加验证 用户名字和手机号 图片类型啥的
    $user_name = trim($_REQUEST['user_name']);
    $tel = intval($_REQUEST['tel']);
    $upload_image = $_FILES['image'];

    $imageId = $userMC->addSelfToMysql($tel , $user_name);
    $userMC->uploadFile($upload_image , $imageId);
    echo $imageId;
    return $imageId;

}elseif('showupload' == $act){
    //展示上传页面
    //http://10.1.7.250/moji/index.php?act=showupload
    echo $viewMC->showPage('upload');
    return ;
}elseif('delete' == $act){
    //投票
    //http://10.1.7.250/moji/index.php?act=delete&imageId=6
    $imageId = intval($_REQUEST['imageId']);
    $userMC->setDisplayStatus($imageId);
//    echo $imageId." delete ok";
    return true;
}


require_once PATH_CACHE . 'RedisCache.class.php';
$re = new RedisCache(array('host'=>REDIS_HOST,'port'=>REDIS_PORT));
//$s = $re->sortedsetsIncrby("myset","one",12);
$s = $re->sortedsetsRank('myset','cac');
var_dump($s);
$s = $re->sortedsetsRank('myset','ddd');
var_dump($s);