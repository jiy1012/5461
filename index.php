<?php
/*
*测试时间戳相互转换
*作者:liuyi
*/
date_default_timezone_set("Asia/Shanghai");
if(isset($_POST['type'])) {
	$_POST['type']=trim($_POST['type']);
		switch($_POST['type']) {
		case 'unix': echo  strtotime(trim($_POST['time']));break;
		case 'day': echo  date('z',strtotime(trim($_POST['time'])));break;
		case 'week': echo date('W' ,strtotime(trim($_POST['time'])));break;
		case 'time': echo date('Y-m-d H:i:s' ,trim($_POST['time']));break;
		case 'uday': echo date('z' ,trim($_POST['time']));break;
		case 'uweek': echo date('W' ,trim($_POST['time']));break;
		case 'url_encode' : echo urlencode(trim($_POST['string']));break;
		case 'url_decode' : echo urldecode(trim($_POST['string']));break;
		case 'base64_decode' : echo base64_decode(trim($_POST['string']));break;
		case 'base64_encode' : echo base64_encode(trim($_POST['string']));break;
	}
	exit;
}
?>
<head>
	<Title>UNIX时间戳相互转换</Title>
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
</head>
<script src="http://lib.sinaapp.com/js/jquery/1.8.3/jquery.min.js"></script>
<script>
$(function () {
	$("#Y").keyup(function () { if ($("#Y").val().length == 4) { $("#m").focus();}});
	$("#m").keyup(function () { if ($("#m").val().length == 2) { $("#d").focus();}});
	$("#d").keyup(function () { if ($("#d").val().length == 2) { $("#H").focus();}});
	$("#H").keyup(function () { if ($("#H").val().length == 2) { $("#i").focus();}});
	$("#i").keyup(function () { if ($("#i").val().length == 2) { $("#s").focus();}});
});
function url_encode(){
	var str = $('#before_url').val();
	$.ajax({
		type: "POST",
		url: "index.php",
		data: "type=url_encode&string="+str,
		dataType: 'html',
		success: function(msg){
			$('#after_url').val(msg);
		},
		error:function(error){
			alert(error);
		}
	});
}
function url_decode(){
	var str = $('#after_url').val();
	$.ajax({
		type: "POST",
		url: "index.php",
		data: "type=url_decode&string="+str,
		dataType: 'html',
		success: function(msg){
			$('#before_url').val(msg);
		},
		error:function(error){
			alert(error);
		}
	});
}
function base64_encode(){
	var str = $('#before_base').val();
	$.ajax({
		type: "POST",
		url: "index.php",
		data: "type=base64_encode&string="+str,
		dataType: 'html',
		success: function(msg){
			$('#after_base').val(msg);
		},
		error:function(error){
			alert(error);
		}
	});
}
function base64_decode(){
	var str = $('#after_base').val();
	$.ajax({
		type: "POST",
		url: "index.php",
		data: "type=base64_decode&string="+str,
		dataType: 'html',
		success: function(msg){
			$('#before_base').val(msg);
		},
		error:function(error){
			alert(error);
		}
	});
}
function timeto (type){
		if ($('#m').val()>12||$('#d').val()>31||$('#H').val()>24||$('#i').val()>60||$('#s').val()>60)
	{
		alert('你丫sb吧！');return false;
	}
	if ($('#Y').val()==''||$('#Y').val()==0||$('#Y').val()<1970){alert('你丫sb吧！');return false;};
	if ($('#m').val()==''){$('#m').val(0);};
	if ($('#d').val()==''){$('#d').val(0);};
	if ($('#H').val()==''){$('#H').val(0);};
	if ($('#i').val()==''){$('#i').val(0);};
	if ($('#s').val()==''){$('#s').val(0);};
	var time = $('#Y').val()+'-'+$('#m').val()+'-'+$('#d').val()+' '+$('#H').val()+':'+$('#i').val()+':'+$('#s').val();
	if (type=='unix')
	{
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=unix&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#t').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}else if(type=='day'){
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=day&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#t').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}else if(type=='week'){
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=week&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#t').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}
}
function unixto(type){
	var time = $('#unixtime').val();
	if (time=='' ||time==0)
	{
		alert('你丫sb吧！');return false;
	}
	if (type=='time')
	{
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=time&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#u').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}else if(type=='uday'){
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=uday&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#u').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}else if(type=='uweek'){
		$.ajax({
				type: "POST",
				url: "index.php",
				data: "type=uweek&time="+time,
				dataType: 'html',
				success: function(msg){
					$('#u').val(msg);
				},
				error:function(error){
					alert(error);
				}
		});
	}
}
function checkinput(id,val){
	if (id=='Y'&&val<1970&&val!=''){alert ('你丫sb啊，查询晚于1970年的！');$("#Y").focus();}
	if (id=='m'&&val>12&&val!=''){alert ('你丫sb啊，月份能大于12？');$("#m").focus();}
	if (id=='d'&&val>31&&val!=''){alert ('你丫sb啊，日期能大于31？');$("#d").focus();}
	if (id=='H'&&val>24&&val!=''){alert ('你丫sb啊，小时能大于24？');$("#H").focus();}
	if (id=='i'&&val>60&&val!=''){alert ('你丫sb啊，分钟能大于60？');$("#i").focus();}
	if (id=='s'&&val>60&&val!=''){alert ('你丫sb啊，秒能大于60？');$("#s").focus();}
}
</script>
<script>
//var myDate = new Date();
//myDate.getYear();        //获取当前年份(2位)
//myDate.getFullYear();    //获取完整的年份(4位,1970-????)
//myDate.getMonth();       //获取当前月份(0-11,0代表1月)
//myDate.getDate();        //获取当前日(1-31)
//myDate.getDay();         //获取当前星期X(0-6,0代表星期天)
//myDate.getTime();        //获取当前时间(从1970.1.1开始的毫秒数)
//myDate.getHours();       //获取当前小时数(0-23)
//myDate.getMinutes();     //获取当前分钟数(0-59)
//myDate.getSeconds();     //获取当前秒数(0-59)
//myDate.getMilliseconds();    //获取当前毫秒数(0-999)
//myDate.toLocaleDateString();     //获取当前日期
//var mytime=myDate.toLocaleTimeString();     //获取当前时间
//myDate.toLocaleString( );        //获取日期与时间
var timer;
function timer(){
	timer=setInterval("now()",1000);
}
function pause(){
	clearInterval(timer);
	$('#pause').attr('disabled','disabled');
	$('#goon').removeAttr('disabled');
}
function goon(){
	timer=setInterval("now()",1000);
	$('#pause').removeAttr('disabled');
	$('#goon').attr('disabled','disabled');
}
function now(){
	var myDate = new Date();
	$('#now').val(Math.ceil(myDate.getTime()/1000-1));
	$('#date').val(myDate.toLocaleString());
}
function copytime(msg){
	window.clipboardData.setData("Text",msg);
	alert('已经复制到剪贴板');
}
function unix2human() {
    var unixTimeValue = new Date($('#unixtime').val() * 1000);
    beijingTimeValue = unixTimeValue.toLocaleString();
	$('#u').val(beijingTimeValue);
}
function human2unix() {
    var humanDate = new Date($('#Y').val(), (stripLeadingZeroes($('#m').val())-1), stripLeadingZeroes($('#d').val()), stripLeadingZeroes($('#H').val()), stripLeadingZeroes($('#i').val()), stripLeadingZeroes($('#s').val()));
	$('#t').val(humanDate.getTime()/1000);
}
function stripLeadingZeroes(input) {
    if((input.length > 1) && (input.substr(0,1) == "0")) {
		return input.substr(1);
	} else {
		return input;
	}
}
timer();
</script>
<style type="text/css">
.time_now{}
input{height:28px;border:1px solid #999;margin:0px;padding:0px;text-indent:8px;}
.time_now tr{padding:10px 0px 10px 0px;clear:both;}
.time_now tr th{text-align:right;height:30px;}
.time_now tr td{text-align:left;height:30px;}
.time_now tr td input{width:60px;}
.time_now tr td .input_long{text-align:left;width:500px;}
.time_now .button{color:#fffffb;height:32px;margin:5px 20px 20px 0px;background:#7ccaea;width:111px;float:left;border:0px; cursor:pointer;border:0px;
-webkit-border-radius:4px 4px 4px 4px;-moz-border-radius:4px 4px 4px 4px;-o-border-radius:4px 4px 4px 4px;border-radius:4px 4px 4px 4px;text-align:center;}
</style>
<a href="./first_game.php">闲着没事？来玩个拼图吧</a> 
<a href="./MMclock_Online.html">闲着没事？来看美女</a><a href="./MMclock.html">报时吧</a>
<table cellpadding="0" cellspacing="0" border="0" class="time_now">
	<tr>
		<th>当前UNIX时间：</th><td align='center'><input type="text" id="now" value="" readonly='true' class="input_long"/></td>
	</tr>
	<tr>
		<th>当前格式化时间：</th><td align='center'><input type="text" id="date" value="" readonly='true' class="input_long"/></td>
	</tr>
	<tr>
    	<th></th>
		<td>
			<input type="button" id ="pause" value="暂停" onclick="pause()" class="button"/>
			<input type="button" id ="goon" value="继续" onclick="goon()" disabled="true" class="button"/>
		</td>
	</tr>
	<tr>
		<th>转换成秒时间：</th>
		<td>
			<input type="text" id="Y" value="" maxlength="4" onblur="checkinput(this.id,this.value)" onfocus='select()'/>年
			<input type="text" id="m" value="" maxlength="2" onblur="checkinput(this.id,this.value)" onfocus='select()'/>月
			<input type="text" id="d" value="" maxlength="2" onblur="checkinput(this.id,this.value)" onfocus='select()'/>日
			<input type="text" id="H" value="" maxlength="2" onblur="checkinput(this.id,this.value)" onfocus='select()'/>时
			<input type="text" id="i" value="" maxlength="2" onblur="checkinput(this.id,this.value)" onfocus='select()'/>分
			<input type="text" id="s" value="" maxlength="2" onblur="checkinput(this.id,this.value)" onfocus='select()'/>秒
		</td>
    </tr>
    <tr>
    	<th>输出结果：</th>
		<td align='center'><input type="text" id="t" value="" readonly='true' onfocus='select()' class="input_long"/></td>
	</tr>
    <tr>
    	<th></th>
		<td>
			<input type="button" value="PHP转换时间戳" onclick="timeto('unix')" class="button"/>
			<input type="button" value="JS转换时间戳" onclick="human2unix()" class="button"/>
			<input type="button" value="查询第几天" onclick="timeto('day')" class="button"/>
			<input type="button" value="查询第几周" onclick="timeto('week')" class="button"/>
		</td>
	</tr>
	
	<tr>
		<th>秒时间戳转换：</th>
		<td><input type="text" id="unixtime" value=""  maxlength="11"  onfocus='select()' class="input_long"/></td>
    </tr>
    <tr>
    	<th>输出结果：</th>
		<td align='center'><input type="text" id="u" value="" readonly='true' onfocus='select()' class="input_long"/></td>
	</tr>
	<tr>
    	<th>&nbsp;</th>
		<td>
			<input type="button" value="PHP转换年月日" onclick="unixto('time')" class="button"/>
			<input type="button" value="JS转换年月日" onclick="unix2human()" class="button"/>
			<input type="button" value="查询第几天" onclick="unixto('uday')" class="button"/>
			<input type="button"  value="查询第几周" onclick="unixto('uweek')" class="button"/>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>url_encode/url_decode：</td>
	</tr>
	<tr>
		<th>明文：</th>
		<td><input type="text" id="before_url" value="" class="input_long"/></td>
	</tr>
	<tr>
		<th>密文：</th>
		<td align='center'><input type="text" id="after_url" value=""  class="input_long"/></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="button" value="encode" onclick="url_encode()" class="button"/>
			<input type="button" value="decode" onclick="url_decode()" class="button"/>
		</td>
	</tr>
	<tr>
		<th></th>
		<td>base64_encode/base64_decode：</td>
	</tr>
	<tr>
		<th>明文：</th>
		<td><input type="text" id="before_base" value="" class="input_long"/></td>
	</tr>
	<tr>
		<th>密文：</th>
		<td align='center'><input type="text" id="after_base" value=""  class="input_long"/></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="button" value="encode" onclick="base64_encode()" class="button"/>
			<input type="button" value="decode" onclick="base64_decode()" class="button"/>
		</td>
	</tr>
		<tr style="height:100px"><th>官方群：</th>
		<td>249930997&nbsp;<a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=469c6e2818184684897703ed7857232c3177faf096e52a13cad9f4a99ab74fe0"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="此群真TM有爱" title="此群真TM有爱"></a></td>
		</tr>
</table>
