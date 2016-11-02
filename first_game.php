<?php
/*
*name:first_game.php
*description:拼图
*author:liuyi
*time:2012/12/5 20:06
*/
header('Content-type: text/html; charset=utf8');
require_once('config.inc.php');
define ('SELF_URL','http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
//连接来的初始页面
if(empty($_GET['ticket'])) {
	echo "<a href='".SELF_URL."?ticket=first'>上传一张图片玩</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_list'>从系统中选一张</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_one'>手气不错</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=ip_picture_list'>看看本IP都上传过哪些？</a>";
	exit;
}elseif($_GET['ticket']=='first'){
	//自己上传
// 	echo "<form method='POST' action='first_game.php?ticket=second_upload' enctype='multipart/form-data'> 
// <table >	<tr>	<td>选择图片：</td><td><input type='file' name='playpic'/></td>	</tr>
// 	<tr style='color:red'>		<td>※注意：</td><td>图片格式只允许jpg、bmp、png，大小不超过2M</td>	</tr>
// 	<tr>		<td></td><td><input type='submit' value='确认上传'/></td>	</tr>
// </table>
// </form>";
	echo "由于sina sae 不支持修改文件夹权限，很遗憾本功能取消。。。<br><br><br>";
	echo "但是，有一个新功能代替！可以把网络上的图片作为源图片来玩<br><br>";
	echo "<form method='POST' action='".SELF_URL."?ticket=second_url' enctype='multipart/form-data'> 
<table >	<tr>	<td>粘贴图片源地址：</td><td><input type='text' name='playpicurl' style='width: 500px; height: 25px;'/></td>	</tr>
	<tr>		<td></td><td><input type='submit' value='确认使用'/></td>	</tr>
	<tr style='color:red'>		<td>※注意：<br>获取图片url的方法：</td><td>IE:右键点击图片，点击属性，属性面板的地址一项。<br>火狐:右键点击图片，选择复制图片地址。<br>chrome:右键点击图片，选择复制图片网址。</td>	</tr>
</table>
</form>";
	echo "<a href='".SELF_URL."?ticket=random_list'>从系统中选一张</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_one'>手气不错</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=ip_picture_list'>看看本IP都上传过哪些？</a>";
	exit;
}elseif ($_GET['ticket']=='second_url'){
	$url=trim($_POST['playpicurl']);
	$img_data=$fetchurl->fetch($url);
	if($image->setData( $img_data )!==true||$image->getImageAttr()==false){
		exit('你输入的不是图片地址啊。。。。<a href="#" onclick="window.history.back()">返回重新输入</a>');
	}
	$fieldsvalues=array('pic_name'=>$url,'link_url'=>md5($url),'upload_time'=>time(),'upload_ip'=>$_SERVER['REMOTE_ADDR']);
	$mysql->insertTableValues('first_game', $fieldsvalues);
	echo "恭喜你，上传成功了！<br>";
	$http_url=SELF_URL."?ticket=".md5($url);
	echo "分享连接:<input type='text' value='".$http_url."' style='width: 500px; height: 25px;'><br>";
	echo "<a href='".$http_url."'>点我去玩！ </a>";
	exit;
}elseif($_GET['ticket']=='second_upload') {
	if($_FILES['playpic']['error']>0) {
		exit('上传出错。error:'.$_FILES['playpic']['error']);
	}
	if(!in_array($_FILES['playpic']['type'],array('image/bmp','image/png','image/jpeg'))) {
		exit('图片类型不正确！type:'.$_FILES['playpic']['type']);
	}
	if($_FILES['playpic']['size']>2*1024*1024) {
		exit('图片太大了！换个小点的吧 size:'.round($_FILES['playpic']['size']/1024/1024,3).'M');
	}
	$extname=array_pop(explode('.',$_FILES['playpic']['name']));
	$pic_name=$_SERVER['REMOTE_ADDR'].array_sum(explode(' ',microtime())).'_'.rand(0,1000).'.'.$extname;
	if(move_uploaded_file($_FILES['playpic']['tmp_name'], "Picture/$pic_name")===true) {
		$fieldsvalues=array('pic_name'=>$pic_name,'link_url'=>md5($pic_name),'upload_time'=>time(),'upload_ip'=>$_SERVER['REMOTE_ADDR']);
		$mysql->insertTableValues('first_game', $fieldsvalues);
		echo "恭喜你，上传成功了！<br>";
		$http_url=SELF_URL."?ticket=".md5($pic_name);
		echo "分享连接:<input type='text' value='".$http_url."' >";
		echo "<a href='".$http_url."'>点我去玩！ </a>";
	}else{
		exit('上传失败！');
	}
}elseif ($_GET['ticket']=='random_list'){
	//系统中选一张
	$pictures=$mysql->getAll('first_game','','','rand()',10);
	echo "这些图片怎么样？选一个吧<br>";
	foreach ($pictures as $pic){
		echo "<a href='".SELF_URL."?ticket=".$pic['link_url']."'><img src='".SELF_URL.'?ticket=get_picture&pic_name='.$pic['pic_name']."' width='200px' height='150px'/></a><br>";
	}
	echo "都不喜欢？<a href='".SELF_URL."?ticket=random_list'>再换一次</a><br>";
	echo "<a href='".SELF_URL."?ticket=first'>我要自己上传</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_one'>不选了，系统随机来一张吧</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=ip_picture_list'>看看本IP都上传过哪些？</a>";
	exit;
}elseif ($_GET['ticket']=='random_one'){
	//随机选一张
	$picture=$mysql->getRow('first_game','','','rand()');
// 	print_r($picture);
	echo "这张图片怎么样？试试吧！<br>";
	echo "<a href='".SELF_URL."?ticket=".$picture['link_url']."'><img src='".SELF_URL.'?ticket=get_picture&pic_name='.$picture['pic_name']."' width='200px' height='150px'/></a><br>";
	echo "我不喜欢？<a href='".SELF_URL."?ticket=random_one'>再换一次</a><br>";
	echo "<a href='".SELF_URL."?ticket=first'>我要自己上传</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_list'>从系统中选一张</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=ip_picture_list'>看看本IP都上传过哪些？</a>";
	exit;
}elseif ($_GET['ticket']=='ip_picture_list'){
	//系统中选一张
	$condition='upload_ip="'.$_SERVER['REMOTE_ADDR'].'"';
	$pictures=$mysql->getAll('first_game','',$condition,'',50);
	echo "这些图片怎么样？选一个吧<br>";
	if(!empty($pictures)){
		foreach ($pictures as $pic){
			echo "<a href='".SELF_URL."?ticket=".$pic['link_url']."'><img src='".SELF_URL.'?ticket=get_picture&pic_name='.$pic['pic_name']."' width='200px' height='150px'/></a><br>";
		}
	}
	echo "<a href='".SELF_URL."?ticket=random_list'>从系统中选一张</a><br>";
	echo "<a href='".SELF_URL."?ticket=first'>我要自己上传</a>&nbsp;";
	echo "<a href='".SELF_URL."?ticket=random_one'>不选了，系统随机来一张吧</a>";
	exit;
}elseif($_GET['ticket']=='get_picture'){
	$pic_name=$_GET['pic_name'];
	$img_data=$fetchurl->fetch($pic_name);
	$image->setData( $img_data );
	$image->annotate('5461.sinaapp.com',0.5,SAE_SouthEast,array("name"=>SAE_SimSun, "size"=>25, "weight"=>350, "color"=>"white"));
	$image->exec( 'jpg' , true );
}else{
	$link_url=trim($_GET['ticket']);
	$condition='link_url = "'.$link_url.'"';
	$pic_name=$mysql->getOne('first_game','pic_name',$condition);
	if (empty($pic_name)) {
		echo  '<script language="JavaScript">alert("咱能不在地址栏里瞎输入吗？带你去个好玩的");window.location.href="'.SELF_URL.'";</script>';
	}else{
		$src=SELF_URL.'?ticket=get_picture&pic_name='.$pic_name;
		$html=file_get_contents(VIEW_ROOT.'/first_game.html');
		$html=preg_replace('/####pic_src####/', $src, $html);
		echo $html;
	}
}









?>