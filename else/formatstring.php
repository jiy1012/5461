<?php
/*
*name:
*description:
*author:liuyi
*time:
*/
header('Content-type: text/html; charset=utf8');
error_reporting(E_ALL);


?>
<textarea id='before'></textarea>
<input type="checkbox" id="space" />空格
<input type="checkbox" id="tab" />tab
<input type="checkbox" id="enter" />回车
<input type="checkbox" id="selfsetting" onclick="ChangeStatus()"/>自定义
<input type="text" id="setting_string" value="" disabled="true"/>
<textarea id='after'></textarea>
<input type="button" name="" value="转换" onclick="FormatString()"/>
<script>
function ChangeStatus(){
	if ($('selfsetting').checked==true)
	{
		$('setting_string').disabled=false;
	}else{
		$('setting_string').disabled=true;
	}
}
function $(id){
	return document.getElementById(id);
}
function FormatString(){
	var string=$('before').value;
	var rules=GetCheckedBox();
	if (rules==false)
	{
		return false;
	}
	alert(rules.toString());
}
function GetCheckedBox(){
	var arr=new Array();
	if ($('space').checked==true)
	{
		arr.push(' ');
	}
	if ($('tab').checked==true)
	{
		arr.push('	');
	}
	if ($('enter').checked==true)
	{
		arr.push("\r\n");
	}
	if ($('selfsetting').checked==true)
	{
		if ($('setting_string').value!='')
		{
			arr.push($('setting_string').value);
		}else{
			alert('请输入自定义的字符');
			return false;
		}
	}
	return arr;
}
</script>